<?php

namespace App\Services;

// import
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class UserService
{
    // update
    public function updateProfile(User $user, array $validated): User
    {
        if (array_key_exists('name', $validated)) {
            $user->name = $validated['name'];
        }

        if (array_key_exists('email', $validated)) {
            $user->email = $validated['email'];
        }

        if (array_key_exists('password', $validated)) {
            $user->password = Hash::make($validated['password']);
        }

        // 저장
        $user->save();
        return $user;
    }
}