<?php

namespace App\Repositories\Group\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByRole implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value) {
            return $query->whereHas('groupEmployees', function ($groupEmployeeQuery) use ($value) {
                $groupEmployeeQuery->where('employee_id', $value);
            });
        }
        return $query;

    }
}
