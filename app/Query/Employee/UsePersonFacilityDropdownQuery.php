<?php

namespace App\Query\Employee;

use App\Http\DTO\QueryParam\UsePersonFacilityDropdownParam;
use App\Models\Employee;
use App\Repositories\Employee\Filter\FilterByFacilityGroupId;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UsePersonFacilityDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Employee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::custom('facility_group_id', new FilterByFacilityGroupId()),
        ]);
    }

    public function setFilterParam(UsePersonFacilityDropdownParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
