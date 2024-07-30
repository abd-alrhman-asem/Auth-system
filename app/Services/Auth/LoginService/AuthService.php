<?php

namespace App\Services\Auth\LoginService;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{

    /**
     * @param array $data
     * @return mixed
     * @throws AuthenticationException
     */
    public function authenticate(array $data): mixed
    {
        $loginType = $this->getLoginType($data);
        if ($user = User::where($loginType, $data['identifier'])->first()) {
            throw new ModelNotFoundException('there is no user for this identifier ');
        }
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('Invalid password , please try again.');
        }
        // Generate new personal access token
        return $user->createToken('login-token')->plainTextToken;
    }


    /**
     * @param array $credentials
     * @return string
     */
    private function getLoginType(array $credentials): string
    {
        return filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    }


}
