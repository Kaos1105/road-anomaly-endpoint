<?php

declare(strict_types=1);

namespace App\Http\DTO\Negotiation;

use App\Enums\Common\DateTimeEnum;
use App\Models\Negotiation;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CalendarData extends Data
{
    public function __construct(
        public ?string     $date,
        public ?Collection $negotiations,
    )
    {

    }

    public static function fromCollection(Collection $negotiableCollection): Collection
    {
        $groupDates = $negotiableCollection->groupBy(function (Negotiation $negotiation) {
            return Carbon::parse($negotiation->date_time)->format(DateTimeEnum::DATE_FORMAT_V2);
        });

        $calendar = collect();
        foreach ($groupDates as $date => $negotiations) {
            $calendar->push(CalendarData::from([
                'date' => $date,
                'negotiations' => CalendarNegotiationData::fromCollection($negotiations)
            ]));
        }
        return $calendar;
    }
}
