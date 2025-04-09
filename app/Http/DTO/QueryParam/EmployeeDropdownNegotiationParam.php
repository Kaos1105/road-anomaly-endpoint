<?php

namespace App\Http\DTO\QueryParam;

use App\Enums\Common\UseFlagEnum;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class EmployeeDropdownNegotiationParam extends Data
{
    public function __construct(
        public ?int $useClassification = UseFlagEnum::USE,
        public ?int $companyClassification = null,
        public ?int $siteId = null,
        public ?int $departmentId = null,
        public ?int $notManagementDepartmentId = null,
        public ?int $notClientSiteId = null,
    )
    {
    }
}
