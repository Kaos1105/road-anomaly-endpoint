<?php

namespace App\Repositories\Negotiation\Filter;

use App\Enums\Company\IndependentEnum;
use App\Models\ManagementDepartment;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByManagementDepartmentId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {

        if ($value == IndependentEnum::INDEPENDENT) {
            $ids = ManagementDepartment::query()->whereHas('myCompanyEmployees', function ($query) {
                $query->where('employee_id', \Auth::user()->employee_id);
            })->select('id')->pluck('id');

            return $query->whereHas('clientSite', function ($query) use ($ids) {
                $query->whereIn('management_department_id', $ids);
            });
        }

        return $query->whereHas('clientSite', function ($query) use ($value) {
            $query->where('management_department_id', $value);
        });

    }
}
