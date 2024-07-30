<?php

namespace App\Services\Auth\TokenManeger;

use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class TokensService implements  TokensServiceInterface
{
    /**
     * @param RefreshTokenRequest $request
     * @param $TokenExpireTime
     * @return string
     * @throws AuthenticationException
     */
    public function refreshUserToken(RefreshTokenRequest $request, &$TokenExpireTime): string
    {
        $requestValidated = $request->validated();
        $TokenExpireTime = Carbon::now()->addMinutes(config('sanctum.refresh_expiration'));
        $user = User::where('email', $requestValidated['email'])->first();
        if (!$user || !Hash::check($requestValidated['password'], $user->password)) {
            throw new AuthenticationException('Invalid password , please try again.');
        }
        $user->tokens()->delete();
        $accessToken = $user->createToken(
            'refresh_token',
            [],
            $TokenExpireTime
        );
        return $accessToken->plainTextToken;
    }

}
