<?php

declare(strict_types=1);

namespace App\Http\DTO\CompanyCalendar;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CompanyCalendarData extends Data
{
    public function __construct(
        public ?string $date,
        public ?int    $calendarClassification,
        public ?string $calendarContents,
        public ?int    $workClassification,
        public ?int    $companyId
    )
    {

    }
}
