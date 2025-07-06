<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorAuthController extends Controller
{
    /**
     * Show the donor login form.
     */
    public function showLoginForm()
	{
	    return redirect()->route('login'); // or your specific login route, e.g. 'donor.login.form'
	}
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('donor')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('donor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('donor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('donor.login');
    }
}
