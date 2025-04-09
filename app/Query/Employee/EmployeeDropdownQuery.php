<?php

namespace App\Query\Employee;

use App\Http\DTO\QueryParam\EmployeeDropdownParam;
use App\Models\Employee;
use App\Repositories\Employee\Filter\FilterHasAccessPermission;
use App\Repositories\Employee\Filter\FilterNotHasLogin;
use App\Repositories\Employee\Filter\FilterTransferCompanyId;
use App\Repositories\Employee\Filter\FilterTransferDepartmentId;
use App\Repositories\Employee\Filter\FilterTransferDivisionId;
use App\Repositories\Employee\Filter\FilterTransferSiteId;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Employee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::custom('has_access_permission', new FilterHasAccessPermission()),
            AllowedFilter::custom('not_has_login', new FilterNotHasLogin()),
            AllowedFilter::custom('transfer_company_id', new FilterTransferCompanyId()),
            AllowedFilter::custom('transfer_site_id', new FilterTransferSiteId()),
            AllowedFilter::custom('transfer_department_id', new FilterTransferDepartmentId()),
            AllowedFilter::custom('transfer_division_id', new FilterTransferDivisionId())
        ]);
    }

    public function setFilterParam(EmployeeDropdownParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
