<?php

declare(strict_types=1);

namespace App\Http\DTO\User;

use App\Http\Resources\User\UserResource;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AuthUserData extends Data
{
    public function __construct(
        public string $token,
        public UserResource $user,
    ) {
    }
}
