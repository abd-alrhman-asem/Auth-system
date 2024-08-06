<?php

namespace App\Services\Auth\TokenManeger;


use Illuminate\Support\Carbon;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Sanctum\PersonalAccessToken;

class TokensService implements  TokensServiceInterface
{

    /**
     * @param $request
     * @param $TokenExpireTime
     * @return string
     */
    public function refreshUserToken($request, &$TokenExpireTime): string
    {
        $TokenExpireTime = Carbon::now()->addMinutes(config('sanctum.refresh_expiration'));
        $token = PersonalAccessToken::findToken($request->bearerToken());
        if (!$token || $token->expires_at && $token->expires_at->isPast())
            throw new UnauthorizedException(
                "your code doesn't work any more,
                please try to resend the verification code to your email again
                ");
        $user = $token->tokenable;
        $token->delete();
         return $user->createToken(
            'refresh_token',
            [],
            $TokenExpireTime
        )->plainTextToken;
    }

}
