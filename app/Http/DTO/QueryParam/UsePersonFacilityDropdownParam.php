<?php

namespace App\Http\DTO\QueryParam;

use App\Enums\Common\UseFlagEnum;
use App\Enums\Company\IndependentEnum;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class UsePersonFacilityDropdownParam extends Data
{
    public function __construct(
        public ?int $facilityGroupId = IndependentEnum::INDEPENDENT_NUMBER,
        public ?int $useClassification = UseFlagEnum::USE,
    )
    {
    }
}
