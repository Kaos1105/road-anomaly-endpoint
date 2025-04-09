<?php

namespace App\Http\DTO\QueryParam;

use App\Enums\Common\UseFlagEnum;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class FacilityGroupMemberDropdownParam extends Data
{
    public function __construct(
        public ?bool $groupMember = true,
        public ?bool $hasUserSetting = false,
        public ?bool $hasFacility = true,
        public ?bool $hasUseFacility = false,
        public ?int  $orUseClassification = UseFlagEnum::USE,
    )
    {
    }
}
