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
                'message' => 'Token not provided',
                'errors' => null,
            ], 401);
        }

        if (!str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'message' => 'Invalid token format',
                'errors' => null,
            ], 401);
        }

        $token = substr($authHeader, 7);

        try {
            // 토큰 확인
            $decoded = JWT::decode($token, new Key(env('TOKEN_SECRET'), 'HS256'));
            $user = User::find($decoded->user_id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                    'success' => null,
                ], 401);
            }

            // Controller에 user_id를 보내기
            $request->attributes->set('auth_user_id', $decoded->user_id);
            $request->attributes->set('auth_user', $user);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid token',
                'success' => null,
            ], 401);
        }
        return $next($request);
    }
}
