<?php

namespace App\Query\Schedule;

use App\Http\DTO\QueryParam\DailyScheduleCalendarParam;
use App\Http\DTO\QueryParam\ScheduleCalendarRangeDateParam;
use App\Models\DailySchedule;
use App\Repositories\ScheduleDaily\Filter\FilterByEndDate;
use App\Repositories\ScheduleDaily\Filter\FilterByMonth;
use App\Repositories\ScheduleDaily\Filter\FilterByStartDate;
use App\Repositories\ScheduleTime\Sort\SortByDateTime;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class DailyScheduleQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = DailySchedule::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('month_date', new FilterByMonth()),
            AllowedFilter::exact('employee_id'),
            AllowedFilter::custom('start_date', new FilterByStartDate()),
            AllowedFilter::custom('end_date', new FilterByEndDate()),
        ]);
        $this->allowedSorts([
            AllowedSort::custom('date', new SortByDateTime())
        ]);
    }

    public function setCalendarFilterParam(DailyScheduleCalendarParam $param): static
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
