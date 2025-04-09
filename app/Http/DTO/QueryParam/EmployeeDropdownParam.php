<?php

namespace App\Http\DTO\QueryParam;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class EmployeeDropdownParam extends Data
{
    public function __construct(
        public ?bool $hasAccessPermission = null,
        public ?int  $useClassification = null,
        public ?bool $notHasLogin = null,
    )
    {
    }
}
