<?php

namespace App\Repositories\AccessPermission\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByEmployeeUseClassification implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where('organization_employees.use_classification', $value);
    }
}
