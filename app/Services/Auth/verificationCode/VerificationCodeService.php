<?php

namespace App\Services\Auth\verificationCode;

use App\Events\UserRegisteredEvent;
use App\Exceptions\InvalidVerificationCodeException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use \App\Http\Requests\Auth\ResendVerificationCode;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VerificationCodeService implements verificationCodeInterface
{
    /**
     * @param $request
     * @return void
     * @throws InvalidVerificationCodeException
     */
    public function handleCode($request): void
    {
        if (!$user = User::where('email', $request->email)->first())
            throw  new ModelNotFoundException('this email has no user , try to register first');
        if ($user->email_verified_at)
            throw new AccessDeniedException('your account is already verified , try to login ');
        $this->validateVerificationCode($request);
        Cache::forget($request->ip()); // Remove the code from the cache
        $user->email_verified_at = now();
        $user->save();
    }

    /**
     * @param $request
     * @return string
     */
    public function resendVerificationCode(ResendVerificationCode $request): void
    {
        if (!$user = User::where('email', $request->email)->first())
            throw new ModelNotFoundException('this email has no user , try to register first');
        if ($user->email_verified_at)
            throw new AccessDeniedException('your account is already verified , try to login ');
        if (!cache::get($request->ip()))
            event(new UserRegisteredEvent($user , $request->ip()));
    }

    /**
     * @param Request $request
     * @throws InvalidVerificationCodeException
     */
    private function validateVerificationCode(Request $request): void
    {
        $cachedCode = Cache::get($request->ip());
        if (!$cachedCode || $cachedCode['verificationCode']  !== $request->verification_code) {
            throw new BadRequestHttpException('Verification code has expired or  invalid.');
        }
    }

}
