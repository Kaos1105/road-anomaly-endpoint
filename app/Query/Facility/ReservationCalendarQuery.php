<?php

namespace App\Query\Facility;

use App\Http\DTO\QueryParam\FacilityCalendarParam;
use App\Models\Facility;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReservationCalendarQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Facility::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('facility_group_id'),
            AllowedFilter::exact('facility_classification'),
        ]);
    }

    public function setCalendarFilterParam(FacilityCalendarParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
