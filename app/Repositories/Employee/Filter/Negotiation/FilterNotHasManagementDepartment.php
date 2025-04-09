<?php

namespace App\Repositories\Employee\Filter\Negotiation;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterNotHasManagementDepartment implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereDoesntHave('managementDepartmentEmployees', function (Builder $subQuery) use ($value) {
            $subQuery->where('management_department_id', '=', $value);
        });
    }
}
