<?php

namespace App\Services\Auth\TokenManeger;


interface TokensServiceInterface
{
    public function refreshUserToken( $request, &$TokenExpireTime): string;

}
