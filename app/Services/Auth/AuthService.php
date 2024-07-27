<?php

namespace App\Services\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    /**
     * @param array $data
     * @return Authenticatable|null
     * @throws AuthenticationException
     */
    public function authenticate(array  $data): ?Authenticatable
    {
        $credentials = $this->getCredentials($data);
        return !Auth::attempt($credentials) ?
            throw new AuthenticationException('Invalid credentials.')
            : Auth::user();
    }

    /**
     * @param array $data
     * @return array
     */
    private function getCredentials(array $data): array
    {
        return filter_var($data['identifier'], FILTER_VALIDATE_EMAIL)
            ? ['email' => $data['identifier'], 'password' => $data['password']]
            : ['phone' => $data['identifier'], 'password' => $data['password']];
    }


}
