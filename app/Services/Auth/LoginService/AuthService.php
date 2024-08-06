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
     * @param array $data
     * @return mixed
     * @throws AuthenticationException|ModelNotFoundException|UnauthorizedException
     */
    public function authenticate(LoginRequest $request): mixed
    {
        $data = $request->validated();
        $loginType = $this->getLoginType($data);
        if (!$user = User::where($loginType, $data['identifier'])->first()) {
            throw new ModelNotFoundException('there is no user for this identifier ');
        }
        if (!Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('Invalid password , please try again.');
        }
        if (!$this->ifVUserVerified($user)) {
            throw new UnauthorizedException('you account is not verified , we send code to your email please check your email ');
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
        return filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
    }

    /**
     * @param User $user
     * @return bool
     */
    function ifVUserVerified(User $user): bool
    {
        if (!$user->email_verified_at) {
            event(new UserRegisteredEvent($user));
            return false;
        }
        return true;
    }
}
