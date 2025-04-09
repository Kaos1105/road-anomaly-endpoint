<?php

namespace App\Repositories\ScheduleDaily;

use App\Models\DailySchedule;
use App\Query\Schedule\DailyScheduleQuery;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;

use Spatie\QueryBuilder\QueryBuilder;

class DailyScheduleRepository extends BaseRepository implements IDailyScheduleRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return DailySchedule::class;
    }

    protected string $defaultSort = 'date';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('date'),
            AllowedFilter::exact('employee_id'),
        ];
    }

    protected function allowedScopedFilters(): array
    {
        return [];
    }

    protected function allowedCustomFilters(): array
    {
        return [];
    }

    protected array $allowedSorts = [
        'date',
        'id',
    ];

    protected function allowedCustomSorts(): array
    {
        return [];
    }

    protected array $allowedIncludes = [
    ];

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
            ->addSelect(DailySchedule::$selectProps);
    }

    public function getDetail(DailySchedule $detail): DailySchedule
    {
        return $detail->load([]);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->paginate($this->getPerPage());
    }

    public function getList(DailyScheduleQuery $query): Collection
    {
        return $query->defaultSort($this->defaultSort)
            ->addSelect(DailySchedule::$selectProps)
            ->get();
    }

    public function checkExistDaily(Carbon|string $date, int $employeeId): DailySchedule|null
    {
        return DailySchedule::where([
            'date' => $date,
            'employee_id' => $employeeId
        ])->first();
    }

}
