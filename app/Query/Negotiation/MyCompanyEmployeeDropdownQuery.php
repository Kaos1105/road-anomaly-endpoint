<?php

namespace App\Query\Negotiation;

use App\Http\DTO\QueryParam\MyCompanyEmployeeDropdownParam;
use App\Models\MyCompanyEmployee;
use App\Repositories\MyCompanyEmployee\Filter\FilterByManagementDepartmentId;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MyCompanyEmployeeDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = MyCompanyEmployee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::custom('management_department_id', new FilterByManagementDepartmentId()),
        ]);
    }

    public function setFilterParam(MyCompanyEmployeeDropdownParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
