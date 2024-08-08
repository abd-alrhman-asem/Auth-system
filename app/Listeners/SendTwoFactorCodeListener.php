<?php

namespace App\Listeners;

use App\Actions\GenerateVerificationCodeInterface;
use App\Mail\VerificationCodeToUserEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendTwoFactorCodeListener
{
    /**
     * Create the event listener.
     */
    public GenerateVerificationCodeInterface $generateVerificationCode;

    /**
     * Create the event listener.
     */
    public function __construct(GenerateVerificationCodeInterface $generateVerificationCode)
    {
        $this->generateVerificationCode = $generateVerificationCode;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Generate and send the 2FA code
        $user = $event->user;
        // Generate a verification code
        $twoFACode = $this->generateVerificationCode->execute();
        // Save the verification code and email to the cache as user ip is the key
        Cache::put(
            $event->userIp."2FA",
            [ $user->email, $twoFACode ] ,
            now()->addMinutes(10)
        );
        // Send the verification email
        Mail::to($user->email)->send(new VerificationCodeToUserEmail($twoFACode));    }
}
