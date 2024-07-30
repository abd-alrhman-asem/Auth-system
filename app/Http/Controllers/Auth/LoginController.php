<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService\AuthServiceInterface;

use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    protected AuthServiceInterface $authService ;

    /**
     * @param AuthServiceInterface $authService
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke( LoginRequest $request): JsonResponse
    {
        return loggedInSuccessfully(
            $this->authService->authenticate((array)$request),
            'user logged in successfully'
        );
    }
}
