<?php

namespace App\Repositories\ScheduleWeekly;

use App\Models\WeeklySchedule;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Auth;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class WeeklyScheduleRepository extends BaseRepository implements IWeeklyScheduleRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return WeeklySchedule::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
        ];
    }

    protected function allowedScopedFilters(): array
    {
        return [
        ];
    }

    protected function allowedCustomFilters(): array
    {
        return [];
    }

    protected array $allowedSorts = [
        'id',
        'display_order'
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
            ->addSelect(WeeklySchedule::$selectProps);
    }

    public function getDetail(WeeklySchedule $detail): WeeklySchedule
    {
        return $detail->load([]);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->paginate($this->getPerPage());
    }

    public function getUserWeeklySchedules(array $load = ['user', 'displayEmployee']): Collection
    {
        $authEmployeeId = Auth::user()->employee_id;
        return WeeklySchedule::query()->where('user_id', '=', $authEmployeeId)
            ->with($load)->orderBy('display_order')->get(WeeklySchedule::$selectProps);
    }

    /**
     * @throws \Throwable
     */
    public function upsertSchedules(array $upsertData): Collection
    {
        $authEmployeeId = Auth::user()->employee_id;
        DB::transaction(function () use ($upsertData, $authEmployeeId) {
            WeeklySchedule::where('user_id', '=', $authEmployeeId)->delete();
            WeeklySchedule::insert($upsertData);
        });
        return $this->getUserWeeklySchedules();
    }

    public function getUpdatingSchedule(int $start, int $end = null): Collection
    {
        $authEmployeeId = Auth::user()->employee_id;

        $query = QueryBuilder::for($this->model())
            ->where('user_id', $authEmployeeId)
            ->where('display_order', '>', $start)
            ->where('display_order', '<=', $end);

        return $query->get(WeeklySchedule::$selectProps);
    }
}
