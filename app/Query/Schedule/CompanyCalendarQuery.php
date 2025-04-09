<?php

namespace App\Query\Schedule;

use App\Http\DTO\QueryParam\CompanyCalendarDashboardParam;
use App\Http\DTO\QueryParam\ScheduleCalendarRangeDateParam;
use App\Models\CompanyCalendar;
use App\Repositories\ScheduleDaily\Filter\FilterByEndDate;
use App\Repositories\ScheduleDaily\Filter\FilterByMonth;
use App\Repositories\ScheduleDaily\Filter\FilterByStartDate;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyCalendarQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = CompanyCalendar::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('month_date', new FilterByMonth()),
            AllowedFilter::custom('start_date', new FilterByStartDate()),
            AllowedFilter::custom('end_date', new FilterByEndDate()),
        ]);
    }

    public function setCalendarFilterParam(CompanyCalendarDashboardParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }

    public function setCalendarRangeDateFilterParam(ScheduleCalendarRangeDateParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }

}
