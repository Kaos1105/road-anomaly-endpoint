<?php

namespace App\Http\DTO\QueryParam;

use App\Enums\Common\UseFlagEnum;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class EmployeeDropdownContractParam extends Data
{
    public function __construct(
        public ?int $companyId = null,
        public ?int $siteId = null,
        public ?int $useClassification = UseFlagEnum::USE,
    )
    {
    }
}
