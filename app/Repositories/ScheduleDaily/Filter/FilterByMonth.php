<?php

namespace App\Repositories\ScheduleDaily\Filter;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByMonth implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $date = Carbon::parse($value);
        $start = $date->clone()->startOfMonth()->startOfWeek();
        $end = $date->clone()->endOfMonth()->endOfWeek();
        return $query->whereBetween('date', [$start, $end]);
    }
}
