<?php

// import
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Google OAuth 시작
Route::get('/auth/google', [AuthController::class, 'googleRedirect']);

// Google OAuth 콜백
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);

