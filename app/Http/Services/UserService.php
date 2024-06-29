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

    /**
     * create a user
     *
     * @param array $parameters
     * @return array
     */
    public function create(array $parameters): array
    {
        // Create User
        $user = User::create([
            'name' => $parameters['name'],
            'email' => $parameters['email'],
            'password' => Hash::make($parameters['password']),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
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

    /**
     * update a user
     *
     * @param User $user
     * @param array $parameters
     * @return array
     */
    public function update(User $user, array $parameters): array
    {
        // add updated_at to update array
        $parameters['updated_at'] = date('Y-m-d H:i:s');

        $user->update($parameters);

        // Build return array
        return [
            'message' => 'user updated',
            'user' => $user,
        ];
    }

    /**
     * delete a user
     *
     * @param User $user
     * @return array
     */
    public function delete(User $user): array
    {
        $user->delete();

        // Build return array
        return [
            'message' => 'user deleted',
        ];
    }
}
