<?php

namespace App\Repositories\ScheduleTime;

use App\Enums\Common\PaginationEnum;
use App\Enums\Schedule\CalendarClassificationEnum;
use App\Models\TimeSchedule;
use App\Query\Schedule\TimeScheduleQuery;
use App\Repositories\ScheduleTime\Filter\FilterByEmployee;
use App\Repositories\ScheduleTime\Filter\FilterByWork;
use App\Repositories\ScheduleTime\Sort\SortByDate;
use App\Repositories\ScheduleTime\Sort\SortByDateTime;
use App\Repositories\ScheduleTime\Sort\SortByDayOfWeek;
use App\Repositories\ScheduleTime\Sort\SortByStartTime;
use App\Repositories\ScheduleTime\Sort\SortByUpdateBy;
use App\Repositories\ScheduleTime\Sort\SortByWorkContents;
use App\Repositories\ScheduleTime\Sort\SortByWorkPlace;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as BuilderQuery;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class TimeScheduleRepository extends BaseRepository implements ITimeScheduleRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return TimeSchedule::class;
    }

    protected string $defaultSort = 'date';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('date'),
            AllowedFilter::custom('employee_id', new FilterByEmployee()),
            AllowedFilter::custom('search', new FilterByWork())
        ];
    }

    protected function allowedScopedFilters(): array
    {
        return [];
    }

    protected function allowedCustomFilters(): array
    {
        return [

        ];
    }

    protected array $allowedSorts = [
        'date',
        'id',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('date', new SortByDate()),
            AllowedSort::custom('day', new SortByDayOfWeek()),
            AllowedSort::custom('time', new SortByStartTime()),
            AllowedSort::custom('work_contents', new SortByWorkContents()),
            AllowedSort::custom('work_place', new SortByWorkPlace()),
            AllowedSort::custom('updated_by', new SortByUpdateBy()),
        ];
    }

    protected array $allowedIncludes = [];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
    }

    protected function filters(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                ...$this->allowedFilters,
                ...$this->allowedExactFilters(),
                ...$this->allowedScopedFilters(),
                ...$this->allowedCustomFilters(),
            ])
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts([
                ...$this->allowedSorts,
                ...$this->allowedCustomSorts(),
            ])
            ->defaultSort($this->defaultSort)
            ->addSelect(TimeSchedule::$selectProps);
    }

    public function getDetail(TimeSchedule $detail): TimeSchedule
    {
        return $detail->load([]);
    }

    public function getList(TimeScheduleQuery $query): Collection
    {
        return $query->defaultSort(AllowedSort::custom('date', new SortByDateTime()))
            ->addSelect(TimeSchedule::$selectProps)
            ->with(['group', 'updatedBy'])
            ->get();
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->addSelect(['employee_kana' => function (BuilderQuery $query) {
                $query->select('organization_employees.kana')
                    ->from('organization_employees')
                    ->whereColumn('organization_employees.id', 'schedule_time_schedule.updated_by');
            }])
            ->addSelect(DB::raw("DAYOFWEEK(schedule_time_schedule.date) as day_of_week"))
            ->with(['updatedBy', 'companyCalendar' => function (BelongsTo $companyCalendarQuery) {
//                $companyCalendarQuery->where('schedule_company_calendar.calendar_classification', '<>', CalendarClassificationEnum::WEEKDAY);
            }])
            ->paginate($this->getCursorPerPage(PaginationEnum::PER_PAGE_100));
    }
}
