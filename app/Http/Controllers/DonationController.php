<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function index(Request $request) {
        $cb_svg = File::files(public_path('svg/cb'));

        return view('donate', compact('cb_svg'));
    }

    public function process(Request $request)
    {
        Log::info('Donation attempt', $request->except('stripeToken'));

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'stripeToken' => 'required'
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));
        Log::info('Stripe secret key', ['key' => config('services.stripe.secret')]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'source' => $request->input('stripeToken'),
        ]);

        try {
            $charge = Charge::create([
                'amount' => $request->amount, // Amount in cents
                'currency' => 'mga',
                'description' => 'Donation',
                'customer' => $customer->id,
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
