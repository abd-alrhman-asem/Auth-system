<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\TokenManeger\TokensServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    protected TokensServiceInterface $tokensService;

    public function __construct(TokensServiceInterface $tokensService)
    {
        $this->tokensService = $tokensService;
    }

    public function RestToken(Request $request): JsonResponse
    {

        return loggedInSuccessfully(
            $this->tokensService->refreshUserToken($request, $tokenExpireTime),
            'the user refreshed successfully ',
            now()->addMinutes($tokenExpireTime)
        );
    }
}
