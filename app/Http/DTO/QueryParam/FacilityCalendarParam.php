<?php

namespace App\Http\DTO\QueryParam;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class FacilityCalendarParam extends Data
{
    public function __construct(
        public int  $facilityGroupId,
        public ?int $facilityClassification = null,
    )
    {
    }
}
