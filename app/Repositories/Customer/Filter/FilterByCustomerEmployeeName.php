<?php

namespace App\Repositories\Customer\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCustomerEmployeeName implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        $query->whereHas('employee', function (Builder $employeeQuery) use ($value) {
            $employeeQuery->where('last_name', 'LIKE', '%' . $value . '%')
                ->orwhere('first_name', 'LIKE', '%' . $value . '%');
        });
    }
}
