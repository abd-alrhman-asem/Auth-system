<?php

namespace App\Exceptions;

use Exception;

class InvalidVerificationCodeException extends Exception
{
    public function __construct($message = 'Verification code has expired or is invalid.')
    {
        parent::__construct($message);
    }
}
