<?php

namespace App\Repositories\Employee\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByEmployeeName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (Builder $subQuery) use ($value) {
            $subQuery->where('organization_employees.last_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_employees.code', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_employees.first_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_employees.kana', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_employees.maiden_name', 'LIKE', '%' . $value . '%');
        });
    }
}
