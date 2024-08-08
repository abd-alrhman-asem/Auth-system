<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendVerificationCode;
use App\Http\Requests\Auth\VerificationCodeRequest;
use App\Models\User;
use App\Services\Auth\verificationCode\verificationCodeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class VerificationCodeController extends Controller
{
    protected verificationCodeInterface $verificationCodeService;

    public function __construct(verificationCodeInterface $verificationCodeService)
    {
        $this->verificationCodeService = $verificationCodeService;
    }

    public function checkVerificationCode(VerificationCodeRequest $request): JsonResponse
    {
        $this->verificationCodeService->handleCode($request);
        return successOperationResponse('your account is verified now  enjoy in our app  ');

    }

    public function reSendVerificationCode(ResendVerificationCode $request): JsonResponse
    {
        $this->verificationCodeService->resendverificationCode($request);
        return successOperationResponse(
            " we send the verification code ,please check your email "
        );
    }
}
