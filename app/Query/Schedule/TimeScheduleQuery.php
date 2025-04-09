<?php

namespace App\Query\Schedule;

use App\Http\DTO\QueryParam\ScheduleCalendarRangeDateParam;
use App\Http\DTO\QueryParam\TimeScheduleCalendarParam;
use App\Models\TimeSchedule;
use App\Repositories\ScheduleDaily\Filter\FilterByEndDate;
use App\Repositories\ScheduleDaily\Filter\FilterByMonth;
use App\Repositories\ScheduleDaily\Filter\FilterByStartDate;
use App\Repositories\ScheduleTime\Filter\FilterByEmployee;
use App\Repositories\ScheduleTime\Sort\SortByDateTime;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class TimeScheduleQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = TimeSchedule::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('month_date', new FilterByMonth()),
            AllowedFilter::custom('employee_id', new FilterByEmployee()),
            AllowedFilter::custom('start_date', new FilterByStartDate()),
            AllowedFilter::custom('end_date', new FilterByEndDate()),
        ]);
        $this->allowedSorts([
            AllowedSort::custom('date', new SortByDateTime())
        ]);
    }

    public function setCalendarFilterParam(TimeScheduleCalendarParam $param): static
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
