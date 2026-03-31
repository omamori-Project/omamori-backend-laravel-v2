<?php

namespace App\Http\Controllers;

// import
use App\Common\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


// 상속
class UserProfileController extends BaseController
{
    // プロフィール更新
    public function update(Request $request)
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
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:100'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
        ]);

        // 갱신
        if ($request->filled('name')) {
            $user->name = $validated['name'];
        }

        if ($request->filled('email')) {
            $user->email = $validated['email'];
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        // 저장
        $user->save();
        return $this->successResponse('profile updated', $user);
    }
}
