<?php

namespace App\Query\Department;

use App\Http\DTO\QueryParam\DepartmentDropdownNegotiationParam;
use App\Models\Department;
use App\Repositories\Department\Filter\FilterByCompanyClassification;
use App\Repositories\Department\Filter\FilterByManagementDepartment;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DepartmentDropdownNegotiationQuery extends QueryBuilder
{
    use HasFilter;
    public function __construct(Request $request)
    {
        $query = Department::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::custom('management_department', new FilterByManagementDepartment()),
            AllowedFilter::custom('company_classification', new FilterByCompanyClassification())

        ]);
    }

    public function setFilterParam(DepartmentDropdownNegotiationParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });
        return $this;
    }
}
