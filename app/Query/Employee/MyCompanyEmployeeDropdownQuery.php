<?php

namespace App\Query\Employee;

use App\Http\DTO\QueryParam\EmployeeDropdownNegotiationParam;
use App\Models\Employee;
use App\Repositories\Employee\Filter\Negotiation\FilterByCompanyClassification;
use App\Repositories\Employee\Filter\Negotiation\FilterDepartmentIdByDepartment;
use App\Repositories\Employee\Filter\Negotiation\FilterNotHasClientSite;
use App\Repositories\Employee\Filter\Negotiation\FilterNotHasManagementDepartment;
use App\Repositories\Employee\Filter\Negotiation\FilterSiteIdBySite;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MyCompanyEmployeeDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Employee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::custom('company_classification', new FilterByCompanyClassification(),),
            AllowedFilter::custom('not_management_department_id', new FilterNotHasManagementDepartment()),
        ]);
    }

    public function setFilterParam(EmployeeDropdownNegotiationParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
