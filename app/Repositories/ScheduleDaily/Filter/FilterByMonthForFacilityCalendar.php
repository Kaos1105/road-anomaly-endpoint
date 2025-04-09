<?php

namespace App\Repositories\ScheduleDaily\Filter;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByMonthForFacilityCalendar implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $date = Carbon::parse($value);
        $start = $date->clone()->startOfMonth();
        $end = $date->clone()->endOfMonth();
        return $query->whereBetween('date', [$start, $end]);
    }
}
