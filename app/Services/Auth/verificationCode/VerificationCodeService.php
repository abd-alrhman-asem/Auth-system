<?php

namespace App\Services\Auth\verificationCode;

use App\Exceptions\InvalidVerificationCodeException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class VerificationCodeService implements  verificationCodeInterface
{

    /**
     * @param $request
     * @return mixed
     * @throws InvalidVerificationCodeException
     */
    public function handleCode($request): mixed
    {
        $user = User::where('email', $request->email)->firstOrFail();
        if ( $user->email_verified_at)
            throw new AccessDeniedException('your account is already verified , try to login ');
        $this->validateVerificationCode($request);
        Cache::forget($this->getCacheKey($request->email)); // Remove the code from the cache
        $user->email_verified_at = now();
        $user->save();
        return $user->createToken(
            'verification-token' ,
            expiresAt: now()->addMinutes(config('sanctum.expiration'))
        )->plainTextToken;
    }

    /**
     * @param Request $request
     * @throws InvalidVerificationCodeException
     */
    private function validateVerificationCode(Request $request): void
    {
        $keyForCachedCode = $this->getCacheKey($request->email);
        $cachedCode = Cache::get($keyForCachedCode);
        if (!$cachedCode || $cachedCode !== $request->verification_code) {
            throw new InvalidVerificationCodeException('Verification code has expired or  invalid.');
        }
    }

    /**
     * @param string $email
     * @return string
     */
    private function getCacheKey(string $email): string
    {
        return 'verificationCode_' . $email;
    }


}
