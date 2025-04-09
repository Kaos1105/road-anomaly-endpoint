<?php

namespace App\Http\DTO\QueryParam;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class TimeScheduleCalendarParam extends Data
{
    public function __construct(
        public ?string $monthDate = null,
        public ?int    $employeeId = null,
    )
    {
    }
}
