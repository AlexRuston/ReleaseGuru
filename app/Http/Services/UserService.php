<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct()
    {
        //
    }

    public function create(array $parameters): array
    {
        // Create User
        $user = User::create([
            'name' => $parameters['name'],
            'email' => $parameters['email'],
            'password' => Hash::make($parameters['password']),
        ]);

        // Create access token
        $token = $user->createToken('authtoken')->plainTextToken;

        /*
         * trigger the Registered event
         * */
        event(new Registered($user));

        // Build return array
        return [
            'message' => 'user created',
            'user' => $user,
            'token' => $token
        ];
    }
}
