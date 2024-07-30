<?php

namespace App\Services\Auth\RegisterService;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

interface RegisterServiceInterface
{
    /**
     * Register a new user.
     *
     * @param  RegisterRequest  $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request);
}
