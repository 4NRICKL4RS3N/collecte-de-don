<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\MailTesting;
use App\Mail\PaymentSuccessful;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\Webhook;
use GuzzleHttp\Client;

class DonationController extends Controller
{
    protected $exchangeData;
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
        $this->setExchangeData();

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
        // create donation
        $donation = Donation::create([
            'project_id' => $request->project,
            'user_id' => $user->id,
            'donation_amount' => $validatedData['amount'],
            'status' => 0,
        ]);

        $exchanged_amount = $this->convertMGAtoUSD($validatedData['amount']);
        $paymentIntent = PaymentIntent::create([
            'amount' => round($exchanged_amount * 100), // Convert to cents
            'currency' => 'usd',
            'payment_method_types' => ['card', 'paypal'],
            'metadata' => [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'donation_id' => $donation->id,
            ],
        ]);
//        Log::info('intent made', [$paymentIntent->client_secret, $request->name, $request->email]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'donation_id' => $donation->id,
        ]);
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

    public function process(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent);

            if ($paymentIntent->status === 'succeeded') {
                // Save payment to database
                Log::info('paymentmande', [$paymentIntent->id, $paymentIntent->amount, $paymentIntent->metadata]);

                return response()->json(['success' => true]);
            } else {
                Log::error('Payment not successful');
                return response()->json(['error' => 'Payment not successful'], 400);
            }
        } catch (\Exception $e) {
            Log::error('error', [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function handleWebhook(Request $request)
    {
        $this->setExchangeData();
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

    function setExchangeData() {
        $client = new Client();
        $endpoint = "https://v6.exchangerate-api.com/v6/".config('services.exchangerate_api.key')."/latest/MGA";
        $response = $client->get($endpoint);
        $data = json_decode($response->getBody(), true);
        $this->exchangeData = $data;
    }

    function convertMGAtoUSD($amountMGA) {
        if (isset($this->exchangeData['conversion_rates']['USD'])) {
            $rate = $this->exchangeData['conversion_rates']['USD'];
            return $amountMGA * $rate;
        }
        return 0;
    }

    function convertUSDtoMGA($amountUSD) {
        if (isset($this->exchangeData['conversion_rates']['USD'])) {
            $rate = $this->exchangeData['conversion_rates']['USD'];
            return $amountUSD / $rate;
        }
        return 0;
    }
}
