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

	    // Get donor email and vendor_id
	    $donor = auth()->guard('donor')->user();
	    $donorEmail = $donor->email;
	    $donorId = $donor->id;

	    // For demo: hardcoded vendor_id (you can also pass it from form or select vendor dynamically)
	    $vendorId = 1;

	    \Stripe\Charge::create([
	        'amount' => $request->amount * 100, // Stripe accepts cents
	        'currency' => 'usd',
	        'source' => $request->stripeToken,
	        'description' => 'Donation via AI',
	        'receipt_email' => $donorEmail, // Donor will get a receipt
	        'metadata' => [
	            'donor_id' => $donorId,
	            'donor_email' => $donorEmail,
	            'vendor_id' => $vendorId,
	        ],
	    ]);

	    return redirect()->route('donor.dashboard')->with('success', 'Thank you for your donation!');
	}


    public function vendor_dashboard()
	{
	    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

	    $vendorId = auth()->guard('vendor')->id();

	    // Fetch the latest 100 charges
	    $allCharges = \Stripe\Charge::all(['limit' => 100]);

	    // Filter charges: correct description + matching vendor_id in metadata
	    $charges = collect($allCharges->data)->filter(function ($charge) use ($vendorId) {
	        return $charge->description === 'Donation via AI' &&
	               isset($charge->metadata['vendor_id']) &&
	               $charge->metadata['vendor_id'] == $vendorId;
	    });

	    return view('vendor.dashboard', ['charges' => $charges]);
	}
}
