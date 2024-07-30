<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerificationCodeRequest;
use App\Models\User;
use App\Services\Auth\verificationCode\verificationCodeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class VerificationCodeController extends Controller
{
    protected  verificationCodeInterface $verificationCodeService;
    public function __construct( verificationCodeInterface $verificationCode)
    {
        $this->verificationCodeService = $verificationCode ;
    }

    public function __invoke(VerificationCodeRequest $request):JsonResponse
    {
        return loggedInSuccessfully(
            $this->verificationCodeService->handleCode($request) ,
            "your account is verified now  enjoy in our app ",
            now()->addMinutes(10)
        );


    }
}
