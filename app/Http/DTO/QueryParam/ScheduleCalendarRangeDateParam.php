<?php

namespace App\Http\DTO\QueryParam;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class ScheduleCalendarRangeDateParam extends Data
{
    public function __construct(
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?int    $employeeId = null,
    )
    {
    }
}
