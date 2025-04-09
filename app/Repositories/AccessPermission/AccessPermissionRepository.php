<?php

namespace App\Repositories\AccessPermission;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessPermission\DepartmentIdFilterEnum;
use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Models\AccessHistory;
use App\Models\AccessPermission;
use App\Models\Employee;
use App\Models\System;
use App\Models\Transfer;
use App\Repositories\AccessPermission\Filter\FilterByDepartmentId;
use App\Repositories\AccessPermission\Filter\FilterByEmployeeName;
use App\Repositories\AccessPermission\Filter\FilterByEmployeeUseClassification;
use App\Repositories\AccessPermission\Sort\SortByAccessAt;
use App\Repositories\AccessPermission\Sort\SortByDepartmentDisplayOrder;
use App\Repositories\AccessPermission\Sort\SortByEmployeeDisplayOrder;
use App\Repositories\AccessPermission\Sort\SortByEndDate;
use App\Repositories\AccessPermission\Sort\SortByPermission1;
use App\Repositories\AccessPermission\Sort\SortByStartDate;
use App\Repositories\AccessPermission\Sort\SortBySystemDisplayOrder;
use App\Repositories\AccessPermission\Sort\SortByTransferPosition;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\JoinClause;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class AccessPermissionRepository extends BaseRepository implements IAccessPermissionRepository
{
    use HasPagination;

    public function model(): string
    {
        return AccessPermission::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('employee_id'),
            AllowedFilter::exact('system_id'),
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
        'code',
        'id',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
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
            ->select(AccessPermission::$selectProps);
    }

    public function createAccessPermission(System $system, Collection $employees): int
    {
        $accessPermissions = collect();

        $employees->each(function (Employee $employee) use ($accessPermissions, $system) {
            $accessPermission = new AccessPermission([
                'employee_id' => $employee->id,
                'system_id' => $system->id,
                'permission_1' => Permission1FlagEnum::UN_AUTHORIZED_USER,
                'permission_2' => $system->default_permission_2,
                'permission_3' => $system->default_permission_3,
                'permission_4' => $system->default_permission_4,
                'start_date' => $system->start_date,
                'created_by' => $system->created_by,
                'updated_by' => $system->updated_by,
            ]);

            $accessPermissions->push($accessPermission);
        });

        return AccessPermission::upsert($accessPermissions->toArray(),
            uniqueBy: ['id']);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        $now = Carbon::now()->startOfDay();
        $transferQuery = $this->latestTransferQuery($now);
        $departmentTransferQuery = $transferQuery->clone()
            ->leftJoin('organization_departments', function (JoinClause $join) {
                $join->on('organization_transfers.department_id', '=', 'organization_departments.id');
            });

        $result = QueryBuilder::for($this->model())
            ->leftJoin('organization_employees', function (JoinClause $join) {
                $join->on('organization_employees.id', '=', 'snet_access_permissions.employee_id');
            })
            ->leftJoin('snet_systems', function (JoinClause $join) {
                $join->on('snet_systems.id', '=', 'snet_access_permissions.system_id');
            })
            ->leftJoinSub(
                $this->latestAccessJoin(), 'access_histories', function (JoinClause $join) {
                $join->on('access_histories.employee_id', '=', 'snet_access_permissions.employee_id')
                    ->on('access_histories.system_id', '=', 'snet_access_permissions.system_id');
            })
            ->with(['employee' => function (BelongsTo $employeeQuery) use ($now) {
                $employeeQuery->with(['transfers' => function (HasMany $hasMany) use ($now) {
                    $this->filterTransferByDateConditions($hasMany->getQuery(), $now)->orderByDesc('organization_transfers.id');
//                    if (request('filter.department_id')) {
//                        FilterByDepartmentId::filterDepartment(request('filter.department_id'), $hasMany->getQuery());
//                    }
                    $hasMany->with(['department']);
                }])->select(Employee::$selectProps);
            }, 'system' => function (BelongsTo $systemQuery) use ($now) {
                $systemQuery->selectRaw(
                    "CASE WHEN snet_systems.use_classification = ?
                    OR snet_systems.start_date > ? OR snet_systems.end_date < ? THEN 1 ELSE 2 END as operation_classification",
                    [UseFlagEnum::NOT_USE, $now, $now]
                )->addSelect(System::$selectProps);
            }])
            ->allowedFilters([
                ...$this->allowedFilters,
                ...$this->allowedExactFilters(),
                AllowedFilter::custom('employee_use_classification', new FilterByEmployeeUseClassification()),
                AllowedFilter::custom('employee_name', new FilterByEmployeeName()),
                AllowedFilter::custom('department_id', new FilterByDepartmentId()),
            ])
            ->allowedSorts([
                AllowedSort::custom('employee_order', new SortByEmployeeDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('department_order', new SortByDepartmentDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('transfer_position', new SortByTransferPosition())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('system_order', new SortBySystemDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('start_date', new SortByStartDate())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('end_date', new SortByEndDate())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('permission_1', new SortByPermission1())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('access_at', new SortByAccessAt())->defaultDirection(SortDirection::DESCENDING),
            ])
            ->defaultSort($this->defaultSort)
            ->selectRaw(
                "CASE WHEN snet_access_permissions.permission_1 = ?
                    OR snet_access_permissions.start_date > ? OR snet_access_permissions.end_date < ? THEN 0 ELSE 1 END as permission_classification",
                [Permission1FlagEnum::UN_AUTHORIZED_USER, $now, $now]
            )
            ->addSelect(AccessPermission::$selectProps)
            ->addSelect([
                'department_display_order' => $departmentTransferQuery->clone()->select('organization_departments.display_order'),
                'department_id' => $departmentTransferQuery->clone()->select('organization_departments.id'),
                'transfer_position' => $transferQuery->clone()->select('organization_transfers.position'),
                'access_at' => \DB::raw('access_histories.last_access_at as `access_at`')
            ]);

        return $result->paginate($this->getPerPage());
    }

    private function latestAccessJoin(): Builder
    {
        return AccessHistory::query()
            ->select([
                'employee_id',
                'system_id',
                \DB::raw('MAX(access_at) as last_access_at')
            ])
            ->where('snet_access_histories.action', '=', AccessActionTypeEnum::START)
            ->groupBy('employee_id', 'system_id');
    }

    private function latestTransferQuery(Carbon $today): Builder
    {
        return Transfer::query()
            ->whereColumn('organization_transfers.employee_id', '=', 'snet_access_permissions.employee_id')
            ->where(function (Builder $query) use ($today) {
                $this->filterTransferByDateConditions($query, $today);
            })
            ->orderByDesc('organization_transfers.id')->limit(1);
    }

    public static function filterTransferByDateConditions(Builder $query, Carbon $today): Builder
    {
        $today = $today->startOfDay();
        return $query->where(function (Builder $subQuery) use ($today) {
            $subQuery->where(function (Builder $query) use ($today) {
                $query->where('organization_transfers.start_date', '<=', $today)
                    ->where('organization_transfers.end_date', '>=', $today);
            })->orWhere(function (Builder $query) use ($today) {
                $query->whereNull('organization_transfers.start_date')
                    ->where('organization_transfers.end_date', '>=', $today);
            })->orWhere(function (Builder $query) use ($today) {
                $query->where('organization_transfers.start_date', '<=', $today)
                    ->whereNull('organization_transfers.end_date');
            });
        });
    }

    public function getEmployeeAccessPermission(Employee $employee): Collection
    {
        $now = Carbon::now()->startOfDay();
        return AccessPermission::query()
            ->leftJoin('snet_systems', function (JoinClause $join) {
                $join->on('snet_systems.id', '=', 'snet_access_permissions.system_id');
            })
            ->with(['system' => function (BelongsTo $systemQuery) use ($now) {
                $systemQuery->selectRaw(
                    "CASE WHEN snet_systems.use_classification = ?
                    OR snet_systems.start_date > ? OR snet_systems.end_date < ? THEN 1 ELSE 2 END as operation_classification",
                    [UseFlagEnum::NOT_USE, $now, $now]
                )->addSelect(System::$selectProps);
            }])
            ->where('employee_id', '=', $employee->id)->select(AccessPermission::$selectProps)
            ->selectRaw(
                "CASE WHEN snet_access_permissions.permission_1 = ?
                    OR snet_access_permissions.start_date > ? OR snet_access_permissions.end_date < ? THEN 0 ELSE 1 END as permission_classification",
                [Permission1FlagEnum::UN_AUTHORIZED_USER, $now, $now]
            )->orderBy('snet_systems.display_order')->get();
    }

    public function getSystemAccessiblePermission(string $systemCode, bool $checkIsActive = false): Collection
    {
        $query = AccessPermission::query()->where('permission_1', '>=', Permission1FlagEnum::SYSTEM_USER);
        if ($checkIsActive) {
            $query = $query->where(function ($conditionQuery) {
                $today = Carbon::now()->startOfDay();
                $conditionQuery->where(function (Builder $query) use ($today) {
                    $query->where('start_date', '<=', $today)
                        ->where('end_date', '>=', $today);
                })->orWhere(function (Builder $query) use ($today) {
                    $query->whereNull('start_date')
                        ->where('end_date', '>=', $today);
                })->orWhere(function (Builder $query) use ($today) {
                    $query->where('start_date', '<=', $today)
                        ->whereNull('end_date');
                });
            });
        }
        return $query->whereHas('employee', function (Builder $employeeQuery) {
            $employeeQuery->where('use_classification', UseFlagEnum::USE);
        })
            ->whereHas('system', function (Builder $employeeQuery) use ($systemCode) {
                $employeeQuery->where('code', $systemCode);
            })
            ->select(AccessPermission::$selectProps)->get();
    }
}
