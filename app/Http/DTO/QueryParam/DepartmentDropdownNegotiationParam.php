<?php

namespace App\Http\DTO\QueryParam;

use App\Enums\Company\CompanyClassificationEnum;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
#[MapInputName(SnakeCaseMapper::class)]
class DepartmentDropdownNegotiationParam extends Data
{
    public function __construct(
        public ?int    $id = null,
        public ?int    $useClassification = null,
        public ?string $companyClassification = CompanyClassificationEnum::SHINNICHIRO,
        public ?bool   $managementDepartment = null,
    )
    {
    }
}
