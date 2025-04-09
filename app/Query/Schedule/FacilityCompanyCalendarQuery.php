<?php

namespace App\Query\Schedule;

use App\Http\DTO\QueryParam\FacilityCompanyCalendarParam;
use App\Models\CompanyCalendar;
use App\Repositories\ScheduleDaily\Filter\FilterByHolidayDisplay;
use App\Repositories\ScheduleDaily\Filter\FilterByMonthForFacilityCalendar;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FacilityCompanyCalendarQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = CompanyCalendar::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('month_date', new FilterByMonthForFacilityCalendar()),
        ]);
    }

    public function setCalendarFilterParam(FacilityCompanyCalendarParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
