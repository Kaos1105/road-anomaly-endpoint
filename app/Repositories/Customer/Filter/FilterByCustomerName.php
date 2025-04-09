<?php

namespace App\Repositories\Customer\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCustomerName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (Builder $query) use ($value) {
            $query->where('category_name', 'LIKE', '%' . $value . '%')
                ->orWhere(function (Builder $subQuery) use ($value) {
                    return $subQuery->whereHas('displayTransfer.company', function (Builder $companyQuery) use ($value) {
                        $companyQuery->where('long_name', 'LIKE', '%' . $value . '%')
                            ->orWhere('short_name', 'LIKE', '%' . $value . '%')
                            ->orWhere('kana', 'LIKE', '%' . $value . '%');
                    });
                })
                ->orWhere(function (Builder $subQuery) use ($value) {
                    return $subQuery->whereHas('employee', function (Builder $employeeQuery) use ($value) {
                        $employeeQuery->where('last_name', 'LIKE', '%' . $value . '%')
                            ->orwhere('first_name', 'LIKE', '%' . $value . '%')
                            ->orwhere('maiden_name', 'LIKE', '%' . $value . '%')
                            ->orwhere('kana', 'LIKE', '%' . $value . '%');
                    });
                });
        });
    }
}
