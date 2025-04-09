<?php

namespace App\Repositories\Negotiation\Filter;

use App\Enums\Company\IndependentEnum;
use App\Models\ManagementDepartment;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByManagementDepartmentIdBelong implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value == IndependentEnum::INDEPENDENT) {
            $ids = ManagementDepartment::query()->whereHas('myCompanyEmployees', function ($query) {
                $query->where('employee_id', \Auth::user()->employee_id);
            })->select('id')->pluck('id');
            return $query->whereIn('management_department_id', $ids);
        }

        return $query->where('management_department_id', $value);
    }
}
