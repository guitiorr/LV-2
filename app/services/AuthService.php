<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{
    public function login(array $credentials)
{
    $obtainedUser = DB::select(
        'EXEC sp_GetUserByEmail @Email = ?',
        [$credentials['email']]
    );

    if (count($obtainedUser) === 0) {
        return [
            'status' => false,
            'message' => 'Invalid credentials'
        ];
    }

    $user = User::find($obtainedUser[0]->id);

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return [
            'status' => false,
            'message' => 'Invalid credentials'
        ];
    }

    return [
        'status' => true,
        'message' => 'Login successful',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]
    ];
}
}
