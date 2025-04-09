<?php

namespace App\Repositories\AuthenticationHistory;

use App\Models\AuthenticationHistory;
use App\Repositories\AuthenticationHistory\Filter\FilterByEmployeeId;
use App\Repositories\AuthenticationHistory\Sort\SortByAction;
use App\Repositories\AuthenticationHistory\Sort\SortByDateTime;
use App\Repositories\AuthenticationHistory\Sort\SortByEmployeeDisplayOrder;
use App\Repositories\AuthenticationHistory\Sort\SortByMessage;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AuthenticationHistoryRepository extends BaseRepository implements IAuthenticationHistoryRepository
{
    use HasPagination;

    public function model(): string
    {
        return AuthenticationHistory::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('action'),
        ];
    }

    protected function allowedScopedFilters(): array
    {
        return [
        ];
    }

    protected function allowedCustomFilters(): array
    {
        return [
            AllowedFilter::custom('employee_id', new FilterByEmployeeId()),
        ];
    }

    protected array $allowedSorts = [
        'id',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('authen_at', new SortByDateTime()),
            AllowedSort::custom('user_order', new SortByEmployeeDisplayOrder()),
            AllowedSort::custom('action', new SortByAction()),
            AllowedSort::custom('message', new SortByMessage()),
        ];
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
            ->select(AuthenticationHistory::$selectProps);
    }

    public function findAll(int $numberRecords): Collection
    {
        return $this->filters()->with('employee')->limit($numberRecords)->get();
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model())
            ->leftJoin('organization_employees', function (JoinClause $join) {
                $join->on('organization_employees.id', '=', 'snet_authen_histories.employee_id');
            })
            ->select(AuthenticationHistory::$selectProps)
            ->allowedFilters([
                ...$this->allowedExactFilters(),
                ...$this->allowedCustomFilters(),
            ])
            ->allowedSorts([
                ...$this->allowedCustomSorts(),
                ...$this->allowedSorts,
            ])
            ->defaultSort($this->defaultSort)
            ->with(['employee'])
            ->paginate($this->getLargePerPage());
    }

    /**
     * @throws ValidatorException
     */
    public function createData(string $action, string $message, ?int $employeeId = null): void
    {
        $this->create([
            'employee_id' => $employeeId,
            'action' => $action,
            'message' => $message,
            'authen_at' => Carbon::now()
        ]);
    }

    public function getLastHistory(): QueryBuilder|AuthenticationHistory|null
    {
        return QueryBuilder::for($this->model())->select(AuthenticationHistory::$selectProps)->orderBy('authen_at')->first();
    }

    public function countActionEachMonthByYear(string $year): Collection|null
    {
        return QueryBuilder::for($this->model())
            ->select(
                'action',
                DB::raw('LOWER(DATE_FORMAT(authen_at, "%b")) AS month'),
                DB::raw('COUNT(*) AS action_count')
            )
            ->where(DB::raw('YEAR(authen_at)'), $year)
            ->groupBy('action', 'month')
            ->orderBy('action')
            ->get();
    }

    public function countActionByYears(array $years): Collection|null
    {
        return QueryBuilder::for($this->model())
            ->select(
                'action',
                DB::raw('YEAR(authen_at) AS year'),
                DB::raw('COUNT(*) AS action_count')
            )
            ->whereIn(DB::raw('YEAR(authen_at)'), $years)
            ->groupBy('action', 'year')
            ->orderBy('action')
            ->get();
    }

    public function findTopicDashboard(int $numberRecords): Collection|null
    {
        return QueryBuilder::for($this->model())
            ->select(AuthenticationHistory::$selectProps)
            ->orderByDesc('authen_at')
            ->limit($numberRecords)->get();
    }
}
