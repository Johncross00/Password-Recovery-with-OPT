<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PrimeNumberController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-pwsd', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-pswd', [ResetPasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/prime-numbers', [PrimeNumberController::class, 'getPrimeNumbers']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
