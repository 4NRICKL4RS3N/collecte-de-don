<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Webhook;

class DonationController extends Controller
{
    public function index(Request $request) {
        $cb_svg = File::files(public_path('svg/cb'));

        return view('donate', compact('cb_svg'));
    }

    public function thankYou(Request $request) {
        return view('thanks');
    }

    public function createPaymentIntent(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount * 100, // Convert to cents
            'currency' => 'usd',
            'payment_method_types' => ['card', 'paypal'],
            'metadata' => [
                'name' => $request->name,
                'email' => $request->email,
            ],
        ]);
        Log::info('intent mande', [$paymentIntent->client_secret, $request->name, $request->email]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function process(Request $request) {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent);

            if ($paymentIntent->status === 'succeeded') {
                // Save donation to database
//                Donation::create([
//                    'stripe_id' => $paymentIntent->id,
//                    'amount' => $paymentIntent->amount / 100,
//                    'email' => $paymentIntent->metadata->email,
//                    'name' => $paymentIntent->metadata->name,
//                ]);
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

    public function handleWebhook(Request $request) {
        Log::info("Webhook received");
        Log::info('Stripe-Signature header: ' . $request->header('Stripe-Signature'));
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');
        Log::info('Webhook secret: ' . $endpoint_secret);
        Log::info('Payload: ' . $payload);
        Log::info('Signature: ' . $sig_header);

        $event = null;
        try {
            $event = Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
            );
            Log::info('Event constructed successfully');
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }
        Log::info('Event type: ' . $event->type);
        if ($event->type == 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            Log::info('Payment Intent ID hehe: ' . $paymentIntent->id);
            // Save donation to database
//            Donation::create([
//                'stripe_id' => $paymentIntent->id,
//                'amount' => $paymentIntent->amount / 100,
//                'email' => $paymentIntent->charges->data[0]->billing_details->email,
//                'name' => $paymentIntent->charges->data[0]->billing_details->name,
//            ]);
        }

        return response()->json(['success' => true]);
    }
}
