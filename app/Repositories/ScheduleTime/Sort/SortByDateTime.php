<?php

namespace App\Repositories\ScheduleTime\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDateTime implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $query->orderBy("date")->orderBy("start_time")->orderBy("id");
    }
}
