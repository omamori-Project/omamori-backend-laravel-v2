<?php

namespace App\Repositories;

// import
use App\Models\User;



class UserRepository
{
    // 회원가입
    public function createUser(array $data): User
    {
        return User::create($data);
    }
}