<?php

namespace App\Query\Facility;

use App\Http\DTO\QueryParam\FacilityGroupDropdownParam;
use App\Models\FacilityGroup;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FacilityGroupDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = FacilityGroup::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),

        ]);
    }

    public function setFilterParam(FacilityGroupDropdownParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
