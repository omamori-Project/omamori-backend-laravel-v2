<?php
// 회원 관련 요청 처리
namespace App\Http\Controllers;

// import
use App\Common\Base\BaseController;
use App\Services\AuthService;
use Illuminate\Http\Request;



// 상속
class AuthController extends BaseController
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
        return $this->successResponse('register ok', $user, 201);
    }


    // 로그인
    public function login(Request $request)
    {
        // 입력 내용 확인
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 로그인 처리를 맡임
        $user = $this->authService->login($validated);
        // Response 반환
        return $this->successResponse('login ok', $user, 200);
    }


    // 로그아웃
    public function logout(Request $request)
    {
        $userId = $request->attributes->get('auth_user_id');

        return response()->json([
            'success' => true,
            'message' => 'logout ok',
            'data' => [
            'user_id' => $userId,
        ],
        ]);
    }
}