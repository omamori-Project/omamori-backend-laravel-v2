<?php

// import
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;

// 회원가입
Route::post('/auth/register', [AuthController::class, 'register']);

// 로그인
Route::post('/auth/login', [AuthController::class, 'login']);

// 로그아웃
Route::middleware('jwt.auth')->group(function(){
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

// 내 정보 조회
Route::middleware('jwt.auth')->get('/me', [AuthController::class, 'show']);

// 회원 정보 수정
Route::middleware('jwt.auth')->patch('/me', [UserProfileController::class, 'update']);
