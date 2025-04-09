<?php

namespace App\Query\Employee;

use App\Models\Employee;
use App\Repositories\Employee\Filter\FilterBySystemCode;
use App\Repositories\Employee\Filter\FilterBySystemId;
use App\Repositories\Employee\Sort\SortByEmployeeName;
use App\Repositories\Employee\Sort\SortByPermission1;
use App\Repositories\Employee\Sort\SortByPermission2;
use App\Repositories\Employee\Sort\SortByPermission3;
use App\Repositories\Employee\Sort\SortByPermission4;
use App\Repositories\Employee\Sort\SortByPermissionStartDate;
use App\Repositories\Employee\Sort\SortByPermissionUpdatedDate;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeSystemPermissionQuery extends QueryBuilder
{
    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('employee_name', new SortByEmployeeName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('start_date', new SortByPermissionStartDate())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('permission_1', new SortByPermission1())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('permission_2', new SortByPermission2())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('permission_3', new SortByPermission3())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('permission_4', new SortByPermission4())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('permission_updated_at', new SortByPermissionUpdatedDate())->defaultDirection(SortDirection::ASCENDING),
        ];
    }

    public function __construct(Request $request)
    {
        $query = Employee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('system_code', new FilterBySystemCode()),
            AllowedFilter::custom('system_id', new FilterBySystemId()),
        ])->allowedSorts([
            ...$this->allowedCustomSorts()
        ]);
    }
}
