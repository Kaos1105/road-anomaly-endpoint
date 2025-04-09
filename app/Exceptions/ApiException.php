<?php

namespace App\Exceptions;

use App\Http\DTO\ResponseData;
use App\Trait\HandleErrorException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiException
{
    use HandleErrorException;

    public function __construct(
        public Exception $e,
        public Request   $request
    )
    {
    }

    public function render(): Throwable|ResponseData
    {
        if ($this->request->is('api/*')) {
            if ($this->e instanceof ValidationException) {
                return $this->renderApiResponse($this->e);
            } elseif ($this->e instanceof NotFoundHttpException || $this->e instanceof ModelNotFoundException) {
                return $this->renderApiNotFoundResponse($this->e);
            } elseif ($this->e instanceof AuthenticationException) {
                return $this->renderNotLoginException();
            } elseif ($this->e instanceof BadRequestHttpException) {
                return $this->renderApiBadRequestResponse($this->e);
            } elseif ($this->e instanceof AuthorizationException ||
                ($this->e instanceof HttpException && $this->e->getStatusCode() == Response::HTTP_FORBIDDEN)) {
                return $this->renderForbiddenException($this->e);
            } else {
                return $this->renderServerErrorException($this->e);
            }
        }

        return $this->e;
    }
}
