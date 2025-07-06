<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function showForm()
    {
        return view('donor.donate');
    }

    public function donate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'stripeToken' => 'required|string',
        ]);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        \Stripe\Charge::create([
            'amount' => $request->amount * 100, // Stripe accepts amounts in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Donation via AI',
        ]);

        return redirect()->route('donor.dashboard')->with('success', 'Thank you for your donation!');
    }
}
