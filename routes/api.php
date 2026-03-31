<?php

// import
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// 회원가입
Route::post('/auth/register', [AuthController::class, 'register']);

// 로그인
Route::post('/auth/login', [AuthController::class, 'login']);

// 로그아웃
Route::middleware('jwt.auth')->group(function(){
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});