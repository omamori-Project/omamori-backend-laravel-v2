<?php
// user정보 데이터 취득/저장
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


    // 로그인
    // 이메일으로 user를 1건 취득
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}