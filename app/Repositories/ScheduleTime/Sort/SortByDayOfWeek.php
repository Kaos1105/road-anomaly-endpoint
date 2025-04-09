<?php

namespace App\Repositories\ScheduleTime\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDayOfWeek implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("day_of_week {$direction}")
            ->orderBy("schedule_time_schedule.date")
            ->orderBy("schedule_time_schedule.end_time")
            ->orderBy("employee_kana");
    }
}
