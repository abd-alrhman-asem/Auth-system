<?php

namespace App\Services\Auth\TwoFA;

use App\Events\UserRegisteredEvent;
use App\Events\userVerifiedEvent;
use App\Exceptions\InvalidVerificationCodeException;
use App\Http\Requests\Auth\Resend2FACodeRequest;
use App\Http\Requests\Auth\TwoFARequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TwoFAService implements TwoFAInterface
{
    /**
     * @throws InvalidVerificationCodeException
     */
    public function confirm2FACode(TwoFARequest $request): string
    {
        if (!$user = User::where('email', $request->email)->first())
            throw  new ModelNotFoundException('this email has no user , try to register first');
        if ($user->email_verified_at)
            $this->validate2FACode($request);
        Cache::forget($request->ip()); // Remove the code from the cache
        return $user->createToken(
            '2FA-token',
        )->plainTextToken;

    }

    public function resend2FACode(Resend2FACodeRequest $request): void
    {

        if (!$user = User::where('email', $request->email)->first())
            throw  new ModelNotFoundException('this email has no user , try to register first');
        if (!$user->email_verified_at) {
            event(new UserRegisteredEvent($user, $request->ip()));
            throw new AccessDeniedException('your account is not verified , we sent code to  you email , check your email please');
        }
            event(new userVerifiedEvent($user, $request->ip()));
    }

    /**
     * @throws InvalidVerificationCodeException
     */
    private function validate2FACode( $request): void
    {
        $cachedCode = Cache::get($request->ip()."2FA");
        if (!$cachedCode || $cachedCode['TwoFactorAuthCode'] !== $request->TwoFactorAuth) {
            throw new BadRequestHttpException('2FA code has expired or  invalid.');
        }
    }


}
