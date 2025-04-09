<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessPermission;

use App\Models\Login;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SharedPermissionData extends Data
{
    public function __construct(
        public int $employeeId,
    )
    {
    }
}
