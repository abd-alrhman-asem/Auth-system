<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Resend2FACodeRequest;
use App\Http\Requests\Auth\TwoFARequest;
use App\Services\Auth\TwoFA\TwoFactorAuthInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TwoFactorController extends Controller
{
    public TwoFactorAuthInterface $twoFactorAuthService;

    public function __construct(TwoFactorAuthInterface $twoFactorAuthService)
    {
        $this->twoFactorAuthService = $twoFactorAuthService;
    }

    public function confirmCode(TwoFARequest $request): JsonResponse
    {
        return loggedInSuccessfully(
            $this->twoFactorAuthService->confirm2FACode($request),
            'you are ready , enjoy our website'
        );
    }

    public function resendCode(Resend2FACodeRequest $request): JsonResponse
    {
        $this->twoFactorAuthService->resend2FACode($request);
        return successOperationResponse('the 2FA code was sent to your email , please check your email');

    }


}
