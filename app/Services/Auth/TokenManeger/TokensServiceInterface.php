<?php

namespace App\Services\Auth\TokenManeger;

use App\Http\Requests\Auth\RefreshTokenRequest;

interface TokensServiceInterface
{
    public function refreshUserToken(RefreshTokenRequest $request, &$TokenExpireTime): string;

}
