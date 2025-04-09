<?php

namespace App\Repositories\System;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Models\AccessPermission;
use App\Models\System;
use App\Query\System\SystemDropdownQuery;
use App\Repositories\System\Filter\FilterByCode;
use App\Repositories\System\Sort\SortByCode;
use App\Repositories\System\Sort\SortByCountAccessibleEmployee;
use App\Repositories\System\Sort\SortByDisplayOrder;
use App\Repositories\System\Sort\SortByName;
use App\Repositories\System\Sort\SortByOperationPeriod;
use App\Repositories\System\Sort\SortByThisMonthAccessedTimes;
use App\Repositories\System\Sort\SortByThisYearAccessedHelpTimes;
use App\Repositories\System\Sort\SortByThisYearAccessedTimes;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class SystemRepository extends BaseRepository implements ISystemRepository
{
    use HasPagination;

    public function model(): string
    {
        return System::class;
    }

    protected string $defaultSort = 'id';

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
        return [
        ];
    }

    protected array $allowedSorts = [
        'updated_at',
        'id',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('name', new SortByName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('code', new SortByCode())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('operation_period', new SortByOperationPeriod())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('count_accessible_employees', new SortByCountAccessibleEmployee())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('this_month_accessed_times', new SortByThisMonthAccessedTimes())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('this_year_accessed_times', new SortByThisYearAccessedTimes())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('this_year_accessed_help_times', new SortByThisYearAccessedHelpTimes())->defaultDirection(SortDirection::ASCENDING),
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
            ->select(System::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findByQuery(SystemDropdownQuery $query): Collection|array
    {
        $now = Carbon::now()->startOfDay();

        return $query->select(System::$selectProps)->orderBy($this->defaultSort)->selectRaw(
            "CASE WHEN snet_systems.use_classification = ?
                    OR snet_systems.start_date > ? OR snet_systems.end_date < ? THEN 1 ELSE 2 END as operation_classification",
            [UseFlagEnum::NOT_USE, $now, $now]
        )->get();
    }

    public function getList(): Collection
    {
        $now = Carbon::now()->startOfDay();
        return $this->filters()
            ->selectRaw(
                "CASE WHEN snet_systems.use_classification = ?
                    OR snet_systems.start_date > ? OR snet_systems.end_date < ? THEN 1 ELSE 2 END as operation_classification",
                [UseFlagEnum::NOT_USE, $now, $now]
            )
            ->addSelect([
                'count_accessible_employees' => self::currentAccessPermissionQuery()->clone()->select(
                    ['count_accessible_employees' => \DB::raw('COUNT(organization_employees.id) as `count_accessible_employees`')]
                ),
                'this_month_accessed_times' => self::employeeAccessHistoryQuery()->clone()
                    ->whereMonth('snet_access_histories.access_at', '=', $now->month)->select(
                        ['this_month_accessed_times' => \DB::raw('COUNT(DISTINCT snet_access_histories.employee_id) as `this_month_accessed_times`')]
                    ),
                'this_year_accessed_times' => self::employeeAccessHistoryQuery()->clone()
                    ->whereYear('snet_access_histories.access_at', '=', $now->year)->select(
                        ['this_year_accessed_times' => \DB::raw('COUNT(DISTINCT snet_access_histories.employee_id) as `this_year_accessed_times`')]
                    ),
                'this_year_accessed_help_times' => self::employeeAccessHistoryQuery(AccessActionTypeEnum::HELP)->clone()
                    ->whereYear('snet_access_histories.access_at', '=', $now->year)->select(
                        ['this_year_accessed_times' => \DB::raw('COUNT(snet_access_histories.id) as `this_year_accessed_times`')]
                    )
            ])->get();
    }

    private function currentAccessPermissionQuery(): Builder
    {
        $now = Carbon::now();

        return AccessPermission::query()
            ->whereColumn('snet_access_permissions.system_id', '=', 'snet_systems.id')
            ->join('organization_employees', function (JoinClause $join) {
                $join->on('snet_access_permissions.employee_id', '=', 'organization_employees.id');
            })
            ->where('snet_access_permissions.permission_1', '!=', Permission1FlagEnum::UN_AUTHORIZED_USER)
            ->where(function (Builder $query) use ($now) {
                $query->whereNull('snet_access_permissions.end_date')
                    ->orWhere('snet_access_permissions.end_date', '>=', $now);
            })
            ->where(function (Builder $query) use ($now) {
                $query->whereNull('snet_access_permissions.start_date')
                    ->orWhere('snet_access_permissions.start_date', '<=', $now);
            })
            ->where('organization_employees.use_classification', '=', UseFlagEnum::USE);
    }

    private function employeeAccessHistoryQuery(string $action = AccessActionTypeEnum::START): Builder
    {
        return self::currentAccessPermissionQuery()->join('snet_access_histories', function (JoinClause $join) {
            $join->on('organization_employees.id', '=', 'snet_access_histories.employee_id');
        })
            ->whereColumn('snet_access_histories.system_id', '=', 'snet_systems.id')
            ->where(function (Builder $query) use ($action) {
                $query->where('snet_access_histories.action', $action);
            });
    }

    public function getAuthenticatedSystem(string $code = ''): ?System
    {
        if (!$code) {
            $code = SystemCodeEnum::MAIN;
        }
        return System::where('code', '=', $code)
            ->where('start_date', '<=', Carbon::now())
            ->where('use_classification', '=', UseFlagEnum::USE)
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', Carbon::now());
            })->first();
    }

    public function showDetail(System $detail): System
    {
        return $detail->load(['createdBy', 'updatedBy']);
    }

    public function checkRelations(System $system): Model|System
    {
        return QueryBuilder::for($this->model())
            ->withCount('displays')
            ->find($system->id);
    }

    public function getDataExport(): Collection
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([AllowedFilter::custom('system_code', new FilterByCode())])
            ->get();
    }

    public function getListSystemManagement(): Collection
    {
        $now = Carbon::now();
        return QueryBuilder::for($this->model())
            ->orderBy('id')
            ->select(System::$selectProps)
            ->selectRaw(
                "CASE WHEN snet_systems.use_classification = ?
                    OR snet_systems.start_date > ? OR snet_systems.end_date < ? THEN 1 ELSE 2 END as operation_classification",
                [UseFlagEnum::NOT_USE, $now, $now]
            )->withCount(['accessPermissions' => function (Builder $accessPermissionQuery) use ($now) {
                $accessPermissionQuery->where('permission_1', '<>', Permission1FlagEnum::UN_AUTHORIZED_USER)
                    ->where(function (Builder $query) use ($now) {
                        $query->whereNull('snet_access_permissions.end_date')
                            ->orWhere('snet_access_permissions.end_date', '>=', $now);
                    })
                    ->where(function (Builder $query) use ($now) {
                        $query->whereNull('snet_access_permissions.start_date')
                            ->orWhere('snet_access_permissions.start_date', '<=', $now);
                    });
            }])
            ->get();
    }

    public function getSystemSortedByDisplayOrder(): Collection
    {
        return System::query()->orderBy('display_order')->get();
    }
}
