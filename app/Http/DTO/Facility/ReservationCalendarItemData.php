<?php

declare(strict_types=1);

namespace App\Http\DTO\Facility;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Models\CompanyCalendar;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ReservationCalendarItemData extends Data
{
    public function __construct(
        public string      $date,
        public int         $calendarClassification,
        public int         $workClassification,
        public string|null $calendarContents,
        public Collection  $reservations
    )
    {
    }

    public static function mapFrom(CompanyCalendar $companyCalendar, Collection $reservations): self
    {
        return ReservationCalendarItemData::from([
            ...$companyCalendar->toArray(),
            'date' => DateTimeHelper::formatDateTime($companyCalendar->date, DateTimeEnum::DATE_FORMAT),
            'reservations' => $reservations]);
    }
}
