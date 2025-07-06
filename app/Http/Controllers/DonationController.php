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

    public function vendor_dashboard()
	{
	    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

	    // Fetch the latest 100 charges (adjust as needed)
	    $allCharges = \Stripe\Charge::all(['limit' => 100]);

	    // Filter only charges with the description "Donation via AI"
	    $charges = collect($allCharges->data)->filter(function ($charge) {
	        return $charge->description === 'Donation via AI';
	    });

	    return view('vendor.dashboard', ['charges' => $charges]);
	}
}
