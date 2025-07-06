<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DonorAuthController;
use App\Http\Controllers\Auth\VendorAuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Auth\MultiAuthLogoutController;

Route::get('/', function () {
    return view('welcome');
});

// Donor Routes
Route::prefix('donor')->name('donor.')->group(function () {
    Route::get('login', [DonorAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [DonorAuthController::class, 'login'])->name('login');
    Route::post('logout', [DonorAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:donor')->group(function () {
        Route::view('dashboard', 'donor.dashboard')->name('dashboard');
         Route::get('donate', [DonationController::class, 'showForm'])->name('donate.form');
        Route::post('donate', [DonationController::class, 'donate'])->name('donate');
        // other donor routes
    });
});

// Vendor Routes
Route::prefix('vendor')->name('vendor.')->group(function () {
    Route::get('login', [VendorAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [VendorAuthController::class, 'login'])->name('login');
    Route::post('logout', [VendorAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:vendor')->group(function () {
        //Route::view('dashboard', 'vendor.dashboard')->name('dashboard');
        Route::get('dashboard', [DonationController::class, 'vendor_dashboard'])->name('dashboard');
        // other vendor routes
    });
});

// Default Jetstream dashboard (for web guard)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::post('logout', [MultiAuthLogoutController::class, 'logout'])->name('logout');
