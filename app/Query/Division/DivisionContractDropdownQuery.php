<?php

namespace App\Query\Division;

use App\Http\DTO\QueryParam\DivisionDropdownContractParam;
use App\Models\Division;
use App\Repositories\Division\Filter\FilterBySiteId;
use App\Repositories\Division\Filter\FilterUnUsedWorkplace;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DivisionContractDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Division::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('basic_contract_id', new FilterUnUsedWorkplace()),
            AllowedFilter::custom('site_id', new FilterBySiteId()),
            AllowedFilter::exact('use_classification'),
        ]);
    }

    public function setFilterParam(DivisionDropdownContractParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
