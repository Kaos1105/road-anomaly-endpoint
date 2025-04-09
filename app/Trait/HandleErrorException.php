<?php

namespace App\Trait;

use App\Http\DTO\ResponseData;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait HandleErrorException
{
    public function renderApiResponse(ValidationException $exception): ResponseData
    {
        return ResponseData::from([
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => trans('errors.validation_failed'),
            'errors' => $this->convertApiErrors($exception->errors()),
        ]);
    }

    private function convertApiErrors(array $errors): array
    {
        $result = [];
        foreach ($errors as $k => $error) {
            $result[] = [
                'field' => $k,
                'message' => $error,
            ];
        }

        return $result;
    }

    public function renderApiNotFoundResponse(ModelNotFoundException|NotFoundHttpException $exception): ResponseData
    {
        return ResponseData::from([
            'code' => Response::HTTP_NOT_FOUND,
            'message' => trans('errors.page_not_found'),
            'errors' => $exception->getMessage(),
        ]);
    }

    public function renderNotLoginException(): ResponseData
    {
        return ResponseData::from([
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => trans('errors.unauthorized'),
            'errors' => null,
        ]);
    }

    public function renderApiBadRequestResponse(BadRequestHttpException $exception): ResponseData
    {
        return ResponseData::from([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => trans('errors.page_not_found'),
            'errors' => $exception->getMessage(),
        ]);
    }

    public function renderServerErrorException(\Exception $exception): ResponseData
    {
        return ResponseData::from([
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $exception->getMessage(),
            'errors' => null,
        ]);
    }

    public function renderForbiddenException(\Exception $exception): ResponseData
    {
        return ResponseData::from([
            'code' => Response::HTTP_FORBIDDEN,
            'message' => __('errors.forbidden'),
        ]);
    }

    public function renderUnknownException(Exception $exception): ResponseData
    {
        return ResponseData::from([
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $exception->getMessage(),
        ]);
    }
}
