<?php

namespace App\Repositories\Department\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByManagementDepartment implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value === true) {
            return $query->whereHas('managementDepartments');
        }
        return $query;

    }
}
