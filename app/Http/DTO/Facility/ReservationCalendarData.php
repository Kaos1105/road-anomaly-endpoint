<?php

declare(strict_types=1);

namespace App\Http\DTO\Facility;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ReservationCalendarData extends Data
{
    public function __construct(
        public Collection $companyCalendars,
        public Collection $facilities,
    )
    {
    }
}
