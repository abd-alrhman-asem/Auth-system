<?php

namespace App\Listeners;

use App\Actions\GenerateVerificationCodeInterface;
use App\Events\UserRegisteredEvent;
use App\Mail\VerificationCodeToUserEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeViaEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public  GenerateVerificationCodeInterface $generateVerificationCode
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(
        UserRegisteredEvent $event ,
    ): void
    {
        $user = $event->user;
        // Generate a verification code
        $VerificationCode = $this->generateVerificationCode->execute();
        // Save the verification code to the user
        Cache::put(
            'verificationCode_'.$user->email ,
            $VerificationCode,
            now()->addMinutes(10)
        );
        // Send the verification email
        Mail::to($user->email)->send(new VerificationCodeToUserEmail($VerificationCode));
    }
}
