<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\MailTesting;
use App\Mail\PaymentSuccessful;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\Project;
use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\Webhook;
use GuzzleHttp\Client;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $cb_svg = File::files(public_path('svg/cb'));

        return view('client.pages.donate', compact('cb_svg'));
    }

    public function remerciement(Request $request)
    {
        return view('client.pages.remerciement');
    }

    public function createPaymentIntent(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        //create user
        $user = User::where('email', $validatedData['email'])->first();
        if ($user) {
            if ($user->name !== $validatedData['name']) {
                $user->update([
                    'name' => $validatedData['name'],
                ]);
            }
        } else {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'is_admin' => 0,
            ]);
        }
        $donation = $user->createDonation($request->project, $validatedData['amount']);
        try {
            $paymentIntent = $user->createPaymentIntent($request->project, $validatedData['amount']);
            return response()->json([
                'success' => true,
                'clientSecret' => $paymentIntent->client_secret,
                'donation_id' => $paymentIntent->metadata->donation_id,
            ]);
        } catch (GuzzleException $e) {
            Log::error($e);
            $donation->cancel();
            return response()->json([
                'success' => false,
                'message' => "Erreur sur la conversion de devise"
            ]);
        } catch (ApiErrorException $e) {
            Log::error($e);
            $donation->cancel();
            return response()->json([
                'success' => false,
                'message' => "Le montant spécifié est inférieur au montant minimum autorisé. Utilisez un montant plus élevé et réessayez.",
            ]);
        } catch (\Throwable $e) {
            // Catch any other exceptions
            Log::error($e); // Log the unexpected error for debugging
            $donation->cancel();
            return response()->json([
                'success' => false,
                'message' => 'Une erreur inattendue s\'est produite. Veuillez contacter les responsables.',
            ]);
        }
    }

    public function donationFailed($id)
    {
        $donation = Donation::find($id);
        try {
            $donation::update([
                'status' => 2,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function donationDestroy($id)
    {
        $donation = Donation::find($id);
        try {
            $donation->delete();
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function handleWebhook(Request $request)
    {
        Log::info("Webhook received");
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        $event = null;
        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'charge.succeeded' || $event->type === 'charge.updated') {
            $charge = $event->data->object;
            $paymentIntent = PaymentIntent::retrieve($charge->payment_intent);
            $donationId = $paymentIntent->metadata->donation_id;
            $donation = Donation::find($donationId);
            $amount = $paymentIntent->amount;
            $paymentMethod = $charge->payment_method_details->type ?? 'unknown';

            $payment = Payment::updateOrCreate(
                ['transaction_id' => $charge->payment_intent],
                [
                    'donation_id' => $donationId,
                    'donation_amount' => $donation->donation_amount,
                    'method' => $paymentMethod,
                    'status' => 0 // Default status
                ]
            );

            switch ($event->type) {
                case 'charge.updated':
                    $payment->update(['status' => 1]);
                    $donation = Donation::find($donationId);
                    if ($donation) {
                        $donation->update(['status' => 1]);
                    }
                    // update donation collected of the project
                    if ($donation->project_id) {
                        $totalDonation = Payment::join('donations', 'payments.donation_id', '=', 'donations.id')
                            ->where('donations.project_id', $donation->project_id)
                            ->where('payments.status', 1)
                            ->sum('payments.donation_amount') ?? 0;
                        Project::find($donation->project_id)->update([
                            'donation_collected' => $totalDonation,
                        ]);
                    }
                    // send mail
                    try {
                        Mail::to($donation->user->email)->send(new PaymentSuccessful($donation, $payment));

                        Log::info('Success email sent', [
                            'user_email' => $donation->user->email,
                            'donation_id' => $donation->id,
                            'payment' => $payment->transaction_id,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to send success email', [
                            'error' => $e->getMessage(),
                            'donation_id' => $donation->id
                        ]);
                    }

                    Log::info('Payment and donation confirmed', [
                        'payment_id' => $payment->id,
                        'donation_id' => $donationId
                    ]);
                    break;

                case 'charge.failed':
                    $payment->update(['status' => 2]);
                    Log::info('Payment failed', ['payment_id' => $payment->id]);
                    break;
            }
        }

        return response()->json(['success' => true]);
    }

}
