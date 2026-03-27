<?php

// import
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// 회원가입
Route::post('/auth/register', [AuthController::class, 'register']);