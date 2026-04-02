<?php
// 인증관련 처리
namespace App\Services;

// import
use App\Common\Base\BaseService;
use App\Models\User;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


// 상속
class AuthService extends BaseService
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


    // 로그인
    public function login(array $data)
    {
        // 이메일으로 user 취득
        $user = $this->userRepository->findByEmail($data['email']);
        // user가 없을 때
        if (!$user) {
            abort(401, 'Invalid email or password');
        }

        // 비밀번호 확인
        if (!Hash::check($data['password'], $user->password_hash)) {
            abort(401, 'Invalid email or password');
        }

        // 토큰 작성
        $payload = [
            'user_id' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 // 24시간
        ];

        $token = JWT::encode($payload, env('TOKEN_SECRET'), 'HS256');
        // 성공
        return [
            'user' => $user,
            'token' => $token
        ];
    }


    // Google 로그인
    public function googleLogin()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            $user = $this->userRepository->findByEmail($googleUser->email);

            if ($user) {
                $user->google_id = $googleUser->id;
                $user->save();
            } else {
                $user = User::create([
                    'name' => $googleUser->name ?? 'Google User',
                    'email' => $googleUser->email,
                    'password_hash' => Hash::make(uniqid()),
                    'google_id' => $googleUser->id,
                    'role' => 'user',
                    'is_active' => true,
                ]);
            }
        }

        $payload = [
            'user_id' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24,
        ];

        $token = JWT::encode($payload, env('TOKEN_SECRET'), 'HS256');

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}