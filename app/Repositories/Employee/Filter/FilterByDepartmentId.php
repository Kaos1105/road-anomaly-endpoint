<?php

namespace App\Repositories\Employee\Filter;

use App\Enums\Company\IndependentEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByDepartmentId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value == IndependentEnum::INDEPENDENT) {
            return $query->whereNull('organization_transfers.department_id');
        } else {
            return $query->where('organization_transfers.department_id', $value);
        }
    }
}
