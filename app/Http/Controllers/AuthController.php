<?php

namespace App\Http\Controllers;

// import
use Illuminate\Http\Request;
use App\Services\AuthService;


// 상속
class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    // 회원가입
    public function register(Request $request)
    {
        // 입력 확인
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        // service에 처리를 보내기
        $user = $this->authService->register($validated);

        // Response 반환
        return response()->json([
            'message' => 'register ok',
            'data' => $user,
        ], 201);
    }
}