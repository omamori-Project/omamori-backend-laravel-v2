<?php

namespace App\Services;

// import
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;



class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // 회원가입
    public function register(array $data)
    {
        $passwordHash = Hash::make($data['password']);

        return $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => $passwordHash,
            'role' => 'user',
            'is_active' => true,
        ]);
    }
}