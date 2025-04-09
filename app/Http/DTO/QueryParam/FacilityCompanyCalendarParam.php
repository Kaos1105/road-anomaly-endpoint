<?php

namespace App\Http\DTO\QueryParam;

use App\Enums\Facility\HolidayDisplayEnum;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class FacilityCompanyCalendarParam extends Data
{
    public function __construct(
        public ?string $monthDate = null,
    )
    {
    }
}
