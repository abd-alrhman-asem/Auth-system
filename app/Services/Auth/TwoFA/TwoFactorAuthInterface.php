<?php

namespace App\Services\Auth\TwoFA;

use App\Http\Requests\Auth\Resend2FACodeRequest;
use App\Http\Requests\Auth\TwoFARequest;

interface TwoFactorAuthInterface
{
    public function resend2FACode(Resend2FACodeRequest $request);
    public function confirm2FACode(TwoFARequest $request): string;
}
