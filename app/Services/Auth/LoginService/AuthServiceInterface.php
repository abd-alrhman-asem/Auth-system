<?php

namespace App\Services\Auth\LoginService;

use App\Http\Requests\Auth\LoginRequest;

interface AuthServiceInterface
{
    public function authenticate(LoginRequest $request);


}
