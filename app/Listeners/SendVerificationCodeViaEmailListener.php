<?php

namespace App\Listeners;

use App\Actions\GenerateVerificationCodeInterface;
use App\Events\UserRegisteredEvent;
use App\Mail\VerificationCodeToUserEmail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeViaEmailListener
{

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
    public function handle(UserRegisteredEvent $event,): void
    {
        $user = $event->user;
        // Generate a verification code
        $VerificationCode = $this->generateVerificationCode->execute();
        // Save the verification code and email to the cache as user ip is the key
        Cache::put(
            $event->userIp,
            [
                "userEmail"=>$user->email,
                "verificationCode" => $VerificationCode
            ] ,
            now()->addMinutes(10)
        );
        // Send the verification email
        Mail::to($user->email)->send(new VerificationCodeToUserEmail($VerificationCode));
    }
}
