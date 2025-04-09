<?php

namespace App\Repositories\ManagementDepartment\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where('negotiation_management_departments.name', 'LIKE', '%' . $value . '%');
    }
}
