<?php

namespace App\Services\Auth\verificationCode;

use App\Http\Requests\Auth\ResendVerificationCode;

interface verificationCodeInterface
{
public function handleCode($request):void;
public function resendVerificationCode( ResendVerificationCode $request):void;

}
