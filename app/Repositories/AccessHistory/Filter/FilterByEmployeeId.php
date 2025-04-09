<?php

namespace App\Repositories\AccessHistory\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByEmployeeId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where('snet_access_histories.employee_id', $value);
    }
}
