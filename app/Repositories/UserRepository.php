<?php

namespace App\Repositories;

// import
use App\Models\User;
use App\Common\Base\BaseRepository;


// 상속
class UserRepository extends BaseRepository
{
    // 회원가입
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}