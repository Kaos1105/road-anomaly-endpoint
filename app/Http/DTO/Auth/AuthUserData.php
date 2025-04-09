<?php

declare(strict_types=1);

namespace App\Http\DTO\Auth;

use App\Http\Resources\Employee\EmployeeAuthResource;
use App\Http\Resources\Employee\EmployeePermissionResource;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AuthUserData extends Data
{
    public function __construct(
        public string                     $token,
        public EmployeePermissionResource $user,
    )
    {
    }
}
