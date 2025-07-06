<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vendor;

class DonationController extends Controller
{
    public function showForm()
	{
	    $vendors = Vendor::all(); // Get all vendors

	    return view('donor.donate', compact('vendors'));
	}

    public function donate(Request $request)
	{
	    $request->validate([
	        'amount' => 'required|numeric|min:1',
	        'stripeToken' => 'required|string',
	        'vendor_id' => 'required|exists:vendors,id',
	    ]);

	    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

	    $donor = auth()->guard('donor')->user();

	    \Stripe\Charge::create([
	        'amount' => $request->amount * 100,
	        'currency' => 'usd',
	        'source' => $request->stripeToken,
	        'description' => 'Donation via AI',
	        'receipt_email' => $donor->email,
	        'metadata' => [
	            'vendor_id' => $request->vendor_id,
	            'donor_id' => $donor->id,
	            'donor_email' => $donor->email,
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
