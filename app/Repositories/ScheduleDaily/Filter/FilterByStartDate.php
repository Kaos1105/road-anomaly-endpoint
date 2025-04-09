<?php

namespace App\Repositories\ScheduleDaily\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByStartDate implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {

        return $query->where('date', '>=', $value);
    }
}
