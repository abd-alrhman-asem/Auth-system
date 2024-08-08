<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\VerificationCodeController;
use Illuminate\Support\Facades\Route;


Route::post('/login', LoginController::class)->name('login');
Route::post('/register', RegisterController::class);
Route::post('/verify-code', [VerificationCodeController::class , 'checkVerificationCode']);
Route::post('/resend-verification-code', [VerificationCodeController::class, 'reSendVerificationCode']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', LogoutController::class);
    Route::get('/refresh-token', [TokenController::class , 'RestToken']);

});

Route::post('/resend-2fa-code', [TwoFactorController::class, 'resendCode'])->middleware('auth:api');
Route::post('/confirm-2fa-code', [TwoFactorController::class, 'confirmCode'])->middleware('auth:api');

