<?php

namespace App\Http\DTO;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\LaravelData\Data;

class ResponseData extends Data
{
    public function __construct(
        public int $code,
        public array|Data|JsonResource|null $data = null,
        public ?string $message = '',
        public array|string|null $errors = null,
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json(
            [
                'code' => $this->code,
                'data' => $this->data,
                'message' => $this->message,
                'errors' => $this->errors,
            ],
            $this->code
        );
    }
}
