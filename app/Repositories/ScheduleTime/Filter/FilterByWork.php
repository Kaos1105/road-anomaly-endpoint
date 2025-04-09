<?php

namespace App\Repositories\ScheduleTime\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByWork implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->where(function (EloquentBuilder $query) use ($value) {
            $query->where('work_contents', 'LIKE', '%' . $value . '%')
                ->orWhere('work_place', 'LIKE', '%' . $value . '%');
        });
    }
}
