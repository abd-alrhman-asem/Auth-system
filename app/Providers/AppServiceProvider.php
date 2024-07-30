<?php

namespace App\Providers;

use App\Actions\GenerateVerificationCode;
use App\Actions\GenerateVerificationCodeInterface;
use App\Events\UserRegisteredEvent;
use App\Listeners\SendVerificationCodeViaEmailListener;
use App\Services\Auth\LoginService\AuthService;
use App\Services\Auth\LoginService\AuthServiceInterface;
use App\Services\Auth\RegisterService\RegisterService;
use App\Services\Auth\RegisterService\RegisterServiceInterface;
use App\Services\Auth\TokenManeger\TokensService;
use App\Services\Auth\TokenManeger\TokensServiceInterface;
use App\Services\Auth\verificationCode\verificationCodeInterface;
use App\Services\Auth\verificationCode\VerificationCodeService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(RegisterServiceInterface::class, RegisterService::class);
        $this->app->bind(GenerateVerificationCodeInterface::class, GenerateVerificationCode::class);
        $this->app->bind(verificationCodeInterface::class, VerificationCodeService::class);
        $this->app->bind(TokensServiceInterface::class, TokensService::class);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            UserRegisteredEvent::class,
            SendVerificationCodeViaEmailListener::class,
        );
    }
}
