<?php

namespace App\Services;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;

class AuthService
{
   
     public function register(array $data): User
    {
        $tenant = Tenant::create([
            'name' => $data['tenant_name'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tenant_id' => $tenant->id,
        ]);

        return $user;
    }
}