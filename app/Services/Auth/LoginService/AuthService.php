<?php

namespace App\Services\Auth\LoginService;

use App\Events\UserRegisteredEvent;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class AuthService implements AuthServiceInterface
{


    /**
     * @param LoginRequest $request
     * @return void
     * @throws AuthenticationException
     */
    public function authenticate(LoginRequest $request): void
    {
        $data = $request->validated();
        $loginType = $this->getLoginType($data);
        if (!$user = User::where($loginType, $data['identifier'])->first()) {
            throw new ModelNotFoundException('there is no user for this identifier ');
        }
        if (!Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('Invalid password , please try again.');
        }
        if (!$this->ifVUserVerified($user , $request)) {
            throw new UnauthorizedException('you account is not verified , we send code to your email please check your email ');
        }
    }


    /**
     * @param array $credentials
     * @return string
     */
    private function getLoginType(array $credentials): string
    {
        return filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
    }

    /**
     * @param User $user
     * @return bool
     */
    function ifVUserVerified(User $user , $request): bool
    {
        if (!$user->email_verified_at) {
            event(new UserRegisteredEvent($user , $request->ip()));
            return false;
        }
        return true;
    }
}
