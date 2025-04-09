<?php

namespace App\Repositories\Employee\Filter;

use App\Enums\Company\IndependentEnum;
use App\Models\GroupEmployee;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByFacilityGroupId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value != IndependentEnum::INDEPENDENT_NUMBER) {
            $employeeIds = GroupEmployee::whereHas('group', function ($query) use ($value) {
                $query->whereHas('facilityGroup', function ($query) use ($value) {
                    $query->where('id', $value);
                });
            })->select('employee_id')->get()->pluck('employee_id');
            return $query->whereIn('organization_employees.id', $employeeIds);
        } else {
            return $query->where('organization_employees.id', IndependentEnum::INDEPENDENT_NUMBER);
        }
    }
}
