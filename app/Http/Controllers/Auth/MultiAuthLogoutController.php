<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class MultiAuthLogoutController extends Controller
{
    public function logout(Request $request)
    {
    	//dd('lgmv');
        if (Auth::guard('donor')->check()) {
            Auth::guard('donor')->logout();
            $redirectRoute = 'donor.login.form';
        } elseif (Auth::guard('vendor')->check()) {
            Auth::guard('vendor')->logout();
            $redirectRoute = 'vendor.login.form';
        } else {
            Auth::logout(); // fallback, logs out default guard (web)
            $redirectRoute = 'login'; // default login route
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($redirectRoute);
    }
}
