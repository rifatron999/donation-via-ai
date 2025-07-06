<?php

namespace App\Actions\Fortify;

use App\Models\Donor;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisterCustomUser implements CreatesNewUsers
{
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:donors,email', 'unique:vendors,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:donor,vendor'],
        ])->validate();

        if ($input['role'] === 'donor') {
            $donor = Donor::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
            auth('donor')->login($donor);
            return $donor;
        } else {
            $vendor = Vendor::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
            auth('vendor')->login($vendor);
            return $vendor;
        }
    }
}
