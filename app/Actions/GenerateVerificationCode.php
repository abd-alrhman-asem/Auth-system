<?php

namespace App\Actions;

use Illuminate\Support\Str;

class GenerateVerificationCode implements GenerateVerificationCodeInterface
{
    function execute($length = 6)
    {
        $uppercase = Str::upper(Str::random(1)); // At least one uppercase letter
        $lowercase = Str::lower(Str::random(1)); // At least one lowercase letter
        $numbers = Str::random(1, '0123456789'); // At least one number

        // Generate the remaining random characters
        $remainingLength = $length - 3;
        $remaining = Str::random($remainingLength);

        // Combine all and shuffle
        $code = $uppercase . $lowercase . $numbers . $remaining;

        // Shuffle the characters to avoid predictable patterns
        return Str::shuffle($code);
    }
}
