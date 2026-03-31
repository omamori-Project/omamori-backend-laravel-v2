<?php

namespace App\Http\Middleware;

// import
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;


class JwtAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            return response()->json([
                'success' => false,
                'message' => 'Token not provided'
            ], 401);
        }

        if (!str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token format',
            ], 401);
        }

        $token = substr($authHeader, 7);

        try {
            // 토큰 확인
            $decoded = JWT::decode($token, new Key(env('TOKEN_SECRET'), 'HS256'));
            $user = User::find($decoded->user_id);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 401);
            }

            // Controller에 user_id를 보내기
            $request->attributes->set('auth_user_id', $decoded->user_id);
            $request->attributes->set('auth_user', $user);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token',
            ], 401);
        }
        return $next($request);
    }
}
