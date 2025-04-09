<?php

namespace App\Repositories\Division\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBySiteId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('department', function (Builder $departmentQuery) use ($value) {
            $departmentQuery->where('site_id', $value);
        });
    }
}
