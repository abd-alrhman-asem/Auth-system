<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService\RegisterServiceInterface;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * The register service instance.
     *
     * @var RegisterServiceInterface
     */
    protected RegisterServiceInterface $registerService;

    /**
     * Create a new controller instance.
     *
     * @param RegisterServiceInterface  $registerService
     * @return void
     */
    public function __construct(RegisterServiceInterface $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $this->registerService->register($request);
        return successOperationResponse('user registered , check your email for verification code  ') ;
    }
}
