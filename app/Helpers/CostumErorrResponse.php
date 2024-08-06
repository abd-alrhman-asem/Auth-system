<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Validation\UnauthorizedException;



 function handleNotFoundHttpException(NotFoundHttpException $e): JsonResponse
{
    return notFoundResponse("Not Found: " . $e->getMessage());
}
function handleValidationException(ValidationException $e): JsonResponse
{
    return unprocessableResponse("validation error : " . $e->getMessage());
}
 function handleConflictHttpException(ConflictHttpException $e): JsonResponse
{
    return conflictResponse("conflict : " . $e->getMessage());
}
 function handleModelNotFoundException(ModelNotFoundException $e): JsonResponse
{
    return notFoundResponse("model not found: " . $e->getMessage());
}

 function handleUnprocessableEntityException(UnprocessableEntityHttpException $e): JsonResponse
{
    return unprocessableResponse("Unprocessable: " . $e->getMessage());
}

 function handleAuthenticationException(AuthenticationException $e): JsonResponse
{
    return unauthorizedResponse("unAuthenticate22: " . $e->getMessage());
}
function handleUnauthorizedException(UnauthorizedException $e): JsonResponse
{
    return unauthorizedResponse("unAuthenticate: " . $e->getMessage());
}

function handleAuthorizationException(AuthorizationException $e): JsonResponse
{
    return forbiddenResponse("forbidden: " . $e->getMessage());
}

function handleAccessDeniedException(AccessDeniedException $e): JsonResponse
{
    return forbiddenResponse("forbidden: " . $e->getMessage());
}

function handleBadRequestException(BadRequestHttpException $e): JsonResponse
{
    return badRequestResponse("bad request: " . $e->getMessage());
}
 function handleDefaultException(Throwable $e): JsonResponse
{
    return generalFailureResponse('else:'.$e->getMessage(), $e->getCode());
}
