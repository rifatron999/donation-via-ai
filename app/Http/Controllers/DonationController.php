<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Charge;

class DonationController extends Controller
{
    public function donate(Request $request)
	{
	    Stripe::setApiKey(env('STRIPE_SECRET'));

	    Charge::create([
	        "amount" => $request->amount * 100,
	        "currency" => "usd",
	        "source" => $request->stripeToken,
	        "description" => "Donation",
	    ]);

	    return back()->with('success', 'Thank you for your donation!');
	}
}
