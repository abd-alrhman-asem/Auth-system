<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        // Get bearer token from the request
        $accessToken = $request->bearerToken();
        // Revoke token
        $token = PersonalAccessToken::findToken($accessToken);
        $token->delete();
        return successOperationResponse(' user logged out successfully ');
    }
}
