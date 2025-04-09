<?php

namespace App\Repositories\MyCompanyEmployee\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByManagementDepartmentId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('managementDepartments', function (Builder $query) use ($value) {
            $query->where('management_department_id', $value);
        });
    }
}
