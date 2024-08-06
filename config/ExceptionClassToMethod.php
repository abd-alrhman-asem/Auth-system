<?php


use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

return [
    ModelNotFoundException::class => 'handleModelNotFoundException',
    NotFoundHttpException::class => 'handleNotFoundHttpException',
    UnprocessableEntityHttpException::class => 'handleUnprocessableEntityException',
    AuthenticationException::class => 'handleAuthenticationException',
    AuthorizationException::class => 'handleAuthorizationException',
    BadRequestHttpException::class => 'handleBadRequestException',
    ConflictHttpException::class => 'handleConflictHttpException',
    ValidationException::class => "handleValidationException" ,
    UnauthorizedException::class => "handleUnauthorizedException",
    AccessDeniedException::class => 'handleAccessDeniedException'
];
