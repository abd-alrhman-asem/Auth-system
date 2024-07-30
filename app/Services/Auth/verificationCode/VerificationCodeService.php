<?php

namespace App\Services\Auth\verificationCode;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class VerificationCodeService implements  verificationCodeInterface
{

    public function handleCode($request)
    {
        $keyForCachedCode  = 'verificationCode_'. $request->email ;
        $cachedCode = Cache::get($keyForCachedCode);
        if (!$cachedCode || $cachedCode != $request->verification_code ) {
            throw  new BadRequestException('Verification code has expired or is invalid.');
        }
        if ($cachedCode == $request->verification_code) {
            // Code is correct
            Cache::forget($keyForCachedCode); // Remove the code from the cache
            $user = User::where('email', $request->email)->first();
            return $user->createToken('verification-token')->plainTextToken;
        }    }
}
