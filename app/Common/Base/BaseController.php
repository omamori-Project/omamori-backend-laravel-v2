<?php

namespace App\Common\Base;

// import
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


// 상속
class BaseController extends Controller
{
    // 성공
    protected function successResponse(
        string $message = 'Success',
        mixed $data = null,
        int $status = 200
    ): JsonResponse{
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }


    // 오류
    protected function errorResponse(
        string $message = 'Error',
        mixed $errors = null,
        int $status = 400
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}