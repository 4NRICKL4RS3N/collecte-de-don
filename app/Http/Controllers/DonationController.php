<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function process(Request $request)
    {
        Log::info('Donation attempt', $request->except('stripeToken'));

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'stripeToken' => 'required'
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Amount in cents
                'currency' => 'usd',
                'description' => 'Donation',
                'source' => $request->stripeToken,
                'metadata' => [
                    'donor_name' => $request->name,
                    'donor_email' => $request->email
                ]
            ]);

            Log::info('Successful donation', ['charge_id' => $charge->id, 'amount' => $charge->amount / 100]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your donation!',
                'charge_id' => $charge->id,
                'amount' => $charge->amount / 100
            ]);

        } catch (\Exception $e) {
            Log::error('Donation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your donation. Please try again.'
            ], 400);
        }
    }
}
