<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Auth\VerificationCodeController;
use Illuminate\Support\Facades\Route;


Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post('/verificationCode', VerificationCodeController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', LogoutController::class);
    Route::post('refresh-token', TokenController::class);

});


