<?php

declare(strict_types=1);

namespace App\Http\DTO\Schedule;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\CompanyCalendar\CompanyCalendarDateResource;
use App\Http\Resources\TimeSchedule\TimeScheduleCalendarCollection;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class MonthCalendarData extends Data
{
    public function __construct(
        public ?int                            $id,
        public ?string                         $date,
        public ?int                            $workClassification,
        public ?CompanyCalendarDateResource    $companyCalendar,
        public ?TimeScheduleCalendarCollection $timeSchedule,
    )
    {
    }

    public static function mapCollection(?EloquentCollection $dailyCollection, ?EloquentCollection $companyCalendarCollection, ?EloquentCollection $timeCollection): Collection
    {
        $dateLists = collect([$dailyCollection, $companyCalendarCollection, $timeCollection])
            ->flatMap(fn(EloquentCollection $collection) => $collection->pluck('date'))
            ->unique()
            ->sort()
            ->values();

        return self::handleCollection($dateLists, $dailyCollection, $companyCalendarCollection, $timeCollection);
    }

    private static function handleCollection(Collection $dateLists, ?Collection $dailyCollection, ?Collection $companyCalendarCollection, ?Collection $timeCollection): Collection
    {
        if ($dateLists->count() == 0) {
            return collect();
        }

        $monthlyCollections = [
            'daily' => $dailyCollection->groupBy('date'),
            'company' => $companyCalendarCollection->groupBy('date'),
            'time' => $timeCollection->groupBy('date'),
        ];

        return $dateLists->map(function (string $date) use (
            /**
             * @var array{daily: Collection, company: Collection, time: Collection} $monthlyCollections
             */
            $monthlyCollections
        ) {
            $dateCollection = $monthlyCollections['daily']->get($date);
            $dailySchedule = $dateCollection instanceof EloquentCollection && $dateCollection->isNotEmpty()
                ? $dateCollection->first()->toArray()
                : [];

            $company = $monthlyCollections['company']->get($date);
            $time = $monthlyCollections['time']->get($date);


            return MonthCalendarData::from([
                ...$dailySchedule,
                'date' => $date,
                'company_calendar' => $company ? CompanyCalendarDateResource::make($company[0]) : null,
                'time_schedule' => $time ? new TimeScheduleCalendarCollection($time) : null
            ]);
        });
    }

    public static function mapRangeDateCollection(Carbon $startDate, Carbon $endDate, ?EloquentCollection $dailyCollection, ?EloquentCollection $companyCalendarCollection, ?EloquentCollection $timeCollection): Collection
    {

        $weekly = CarbonPeriod::create($startDate, $endDate);

        $dateRange = collect($weekly)->map(function (Carbon $data) {
            return ['date' => $data->format(DateTimeEnum::DATE_FORMAT_V2)];
        });
        $dateLists = collect([$dailyCollection, $companyCalendarCollection, $timeCollection, $dateRange])
            ->flatMap(fn(Collection $collection) => $collection->pluck('date'))
            ->unique()
            ->sort()
            ->values();

        return self::handleCollection($dateLists, $dailyCollection, $companyCalendarCollection, $timeCollection);
    }
}
