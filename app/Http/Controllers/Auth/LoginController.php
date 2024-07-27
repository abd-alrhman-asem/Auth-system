<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param AuthService $userService
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function __invoke(
        LoginRequest $request ,
        AuthServiceInterface $userService
    ): JsonResponse
    {
       $user =  $userService->authenticate((array)$request);
       return loggedInSuccessfully(
           $user->getRememberToken() ,
           'user logged in successfully'
       );
    }
}
