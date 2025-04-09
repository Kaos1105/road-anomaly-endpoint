<?php

namespace App\Repositories\ScheduleDaily\Filter;

use App\Enums\Facility\HolidayDisplayEnum;
use App\Enums\Schedule\CalendarClassificationEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByHolidayDisplay implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value == HolidayDisplayEnum::NOT_DISPLAY) {
            $query->whereNotIn('calendar_classification',
                [CalendarClassificationEnum::SUNDAY_HOLIDAY, CalendarClassificationEnum::NATIONAL_HOLIDAY]);
        }
        return $query;
    }
}
