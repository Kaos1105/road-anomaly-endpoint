<?php

namespace App\Query\Employee;

use App\Http\DTO\QueryParam\EmployeeDropdownContractParam;
use App\Models\Employee;
use App\Repositories\Employee\Filter\FilterContractCompanyId;
use App\Repositories\Employee\Filter\FilterSupplierSiteId;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeContractQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Employee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('site_id', new FilterSupplierSiteId()),
            AllowedFilter::custom('company_id', new FilterContractCompanyId()),
        ]);
    }

    public function setFilterParam(EmployeeDropdownContractParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
