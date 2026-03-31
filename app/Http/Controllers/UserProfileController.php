<?php

namespace App\Http\Controllers;

// import
use App\Common\Base\BaseController;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;


// 상속
class UserProfileController extends BaseController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // 회원 정보 수정
    public function update(UpdateProfileRequest $request)
    {
        // 토큰 확인
        $user = $request->attributes->get('auth_user');
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Authenticated user not found',
            ], 401);
        }

        // 내용 제한
        $validated = $request->validated();

        $updatedUser = $this->userService->updateProfile($user, $validated);
        
        // 저장
        return $this->successResponse('profile updated', $updatedUser);
    }
}
