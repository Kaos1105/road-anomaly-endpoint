<?php

namespace App\Repositories\AuthenticationHistory\Filter;

use App\Enums\Company\IndependentEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByEmployeeId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value == IndependentEnum::INDEPENDENT) {
            return $query->whereNull('employee_id');
        } else {
            return $query->where('employee_id', $value);
        }
    }
}
