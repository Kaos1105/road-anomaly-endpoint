<?php

namespace App\Repositories\Employee;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Enums\Transfer\MajorHistoryEnum;
use App\Models\AccessHistory;
use App\Models\AccessPermission;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Site;
use App\Models\System;
use App\Models\Transfer;
use App\Query\Employee\EmployeeSupplierQuery;
use App\Query\Employee\EmployeeSystemPermissionQuery;
use App\Repositories\AccessPermission\AccessPermissionRepository;
use App\Repositories\Employee\Filter\FilterByCompanyClassification;
use App\Repositories\Employee\Filter\FilterByCompanyId;
use App\Repositories\Employee\Filter\FilterByCompanyIdSelect;
use App\Repositories\Employee\Filter\FilterByContractClassification;
use App\Repositories\Employee\Filter\FilterByDepartmentId;
use App\Repositories\Employee\Filter\FilterByDivisionId;
use App\Repositories\Employee\Filter\FilterByEmployeeName;
use App\Repositories\Employee\Filter\FilterByEmployeeNameCustomer;
use App\Repositories\Employee\Filter\FilterBySiteId;
use App\Repositories\Employee\Filter\FilterBySystemCode;
use App\Repositories\Employee\Sort\SelectEmployee\SortByCompanyClassification;
use App\Repositories\Employee\Sort\SelectEmployee\SortByCompanyDisplay;
use App\Repositories\Employee\Sort\SelectEmployee\SortByDepartmentDisplay;
use App\Repositories\Employee\Sort\SelectEmployee\SortByDivisionDisplay;
use App\Repositories\Employee\Sort\SelectEmployee\SortByEmployeeKana;
use App\Repositories\Employee\Sort\SelectEmployee\SortByPosition as SortByPositionSelectEmployee;
use App\Repositories\Employee\Sort\SelectEmployee\SortBySiteDisplay;
use App\Repositories\Employee\Sort\SortByCompanyDisplayOrder;
use App\Repositories\Employee\Sort\SortByContractClassification;
use App\Repositories\Employee\Sort\SortByDepartmentDisplayOrder;
use App\Repositories\Employee\Sort\SortByDisplayOrder;
use App\Repositories\Employee\Sort\SortByDivisionDisplayOrder;
use App\Repositories\Employee\Sort\SortByEmployeeCode;
use App\Repositories\Employee\Sort\SortByEmployeeNameOrganization;
use App\Repositories\Employee\Sort\SortByFavorite;
use App\Repositories\Employee\Sort\SortByPosition;
use App\Repositories\Employee\Sort\SortByRepresentFlg;
use App\Repositories\Employee\Sort\SortBySiteDisplayOrder;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as LaravelQueryBuilder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class EmployeeRepository extends BaseRepository implements IEmployeeRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return Employee::class;
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
        return [
            AllowedFilter::custom('system_code', new FilterBySystemCode()),
        ];
    }

    protected array $allowedSorts = [
        'code',
        'id',
        'updated_at'
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
            ->select(Employee::$selectProps);
    }

    public function getEmployeePermission(EmployeeSystemPermissionQuery $query): Collection|array
    {
        $systemId = request('filter.system_id') ?? 0;
        $systemIds = [$systemId];

        // get access_permission_sub query
        return $query->getEloquentBuilder()->select(Employee::$selectProps)->with(
            ['accessPermissions' => function (HasMany $permissionQuery) use ($systemIds) {
                $permissionQuery->where(function (Builder $builder) use ($systemIds) {
                    FilterBySystemCode::querySystemPermission($systemIds, $builder);
                })->with(['system'])->orderBy('updated_by', 'desc');
            }]
        )->addSelect([
            'access_permission_1' => self::currentSystemPermission($systemIds)->clone()->select('permission_1'),
            'access_permission_2' => self::currentSystemPermission($systemIds)->clone()->select('permission_2'),
            'access_permission_3' => self::currentSystemPermission($systemIds)->clone()->select('permission_3'),
            'access_permission_4' => self::currentSystemPermission($systemIds)->clone()->select('permission_4'),
            'access_permission_start_date' => self::currentSystemPermission($systemIds)->clone()->select('start_date'),
            'access_permission_updated_at' => self::currentSystemPermission($systemIds)->clone()->select('updated_at'),
        ])->get();
    }

    private function currentSystemPermission(array $systemIds): Builder
    {
        $query = AccessPermission::query()->whereColumn('snet_access_permissions.employee_id', '=', 'organization_employees.id');
        FilterBySystemCode::querySystemPermission($systemIds, $query)->orderBy('updated_by', 'desc')->limit(1);

        return $query;
    }

    public function getDetail(Employee $employee): Employee
    {
        $systemId = request('filter.system_id') ?? 0;
        $systemIds = [$systemId];

        if (!$systemId) {
            $systemCode = request('filter.system_code') ?? SystemCodeEnum::MAIN;
            $systemIds = System::query()->where('code', $systemCode)->pluck('id')->toArray();
        }

        return $employee->load(['accessPermissions' => function (HasMany $permissionQuery) use ($systemIds) {
            $permissionQuery->where(function (Builder $builder) use ($systemIds) {
                FilterBySystemCode::querySystemPermission($systemIds, $builder);
            })->with(['system'])->orderBy('updated_by', 'desc');
        }]);
    }

    public function showUserDetail(Employee $detail): Employee
    {
        $now = Carbon::now();
        return $detail->load(['logins', 'transfers' => function (HasMany $transferQuery) use ($now) {
            AccessPermissionRepository::filterTransferByDateConditions($transferQuery->getQuery(), $now);
            $transferQuery->orderByDesc('organization_transfers.id')->with(['company', 'site', 'department', 'division']);
        }]);
    }


    public function getAccessedEmployee(System $system): Collection
    {
        $now = Carbon::now();
        $systemId = $system->id;
        $startAction = AccessActionTypeEnum::START;

        return Employee::query()
            ->whereHas('accessHistories', function (Builder $query) use ($systemId, $startAction, $now) {
                $query->where('action', $startAction)
                    ->where('system_id', $systemId)
                    ->where('access_at', '<=', $now);
            })
            ->with([
                'logins.personalAccessTokens',
                'accessHistories' => function (HasMany $query) use ($systemId, $startAction, $now) {
                    $query->where('action', $startAction)
                        ->where('system_id', $systemId)
                        ->where('access_at', '<=', $now)
                        ->orderBy('access_at', 'desc')
                        ->select(AccessHistory::$selectProps)
                        ->limit(1);
                }
            ])->select(Employee::$selectProps)->get();
    }

    public function getUserEmployees(): Collection
    {
        return Employee::query()->has('logins')->select(Employee::$selectProps)->orderBy('display_order')->get();
    }

    public function findByQuery(QueryBuilder $query): Collection
    {
        return $query->select(Employee::$selectProps)->orderBy($this->defaultSort)->get();
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        $today = Carbon::now();
        $transferQuery = $this->firstTransferQuery($today);

        return QueryBuilder::for($this->model())
            ->leftJoin('organization_transfers', function (JoinClause $join) use ($today) {
                $join->on('organization_employees.id', '=', 'organization_transfers.employee_id')
                    ->where(function (JoinClause $query) use ($today) {
                        $this->filterByDateConditions($query, $today);
                    });
            })
            ->addSelect([
                'transfer_position' => $transferQuery->clone()->select('organization_transfers.position',),
                'transfer_contract_classification' => $transferQuery->clone()->select('organization_transfers.contract_classification'),
                'company_name' => $this->queryTransferJoinTable($transferQuery->clone(), Company::class, 'company_id'),
                'company_display_order' => $this->queryTransferJoinTable($transferQuery->clone(), Company::class, 'company_id', 'display_order'),
                'site_name' => $this->queryTransferJoinTable($transferQuery->clone(), Site::class, 'site_id'),
                'site_display_order' => $this->queryTransferJoinTable($transferQuery->clone(), Site::class, 'site_id', 'display_order'),
                'department_name' => $this->queryTransferJoinTable($transferQuery->clone(), Department::class, 'department_id'),
                'department_display_order' => $this->queryTransferJoinTable($transferQuery->clone(), Department::class, 'department_id', 'display_order'),
                'division_name' => $this->queryTransferJoinTable($transferQuery->clone(), Division::class, 'division_id'),
                'division_display_order' => $this->queryTransferJoinTable($transferQuery->clone(), Division::class, 'division_id', 'display_order'),
                'count_favorites' => $this->getCountFavoriteQuery($this->model())
            ])
            ->with(['transfers' => function (HasMany $query) use ($today) {
                $query->with(['company', 'site', 'department', 'division'])
                    ->where(function (Builder $query) use ($today) {
                        $this->filterByDateConditions($query->getQuery(), $today);
                    })
                    ->orderBy('organization_transfers.start_date');
            }])
            ->groupBy(Employee::$selectProps)
            ->allowedFilters([
                AllowedFilter::exact('use_classification'),
                AllowedFilter::custom('name', new FilterByEmployeeName()),
                AllowedFilter::custom('company_id', new FilterByCompanyId()),
                AllowedFilter::custom('site_id', new FilterBySiteId()),
                AllowedFilter::custom('department_id', new FilterByDepartmentId()),
                AllowedFilter::custom('division_id', new FilterByDivisionId()),
                AllowedFilter::custom('contract_classification', new FilterByContractClassification()),
            ])
            ->allowedSorts([
                ...$this->allowedSorts,
                AllowedSort::custom('name', new SortByEmployeeNameOrganization())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('code', new SortByEmployeeCode())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('company_name', new SortByCompanyDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('site', new SortBySiteDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('department', new SortByDepartmentDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('division', new SortByDivisionDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('contract_classification', new SortByContractClassification())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('position', new SortByPosition())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING),
                AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
            ])
            ->defaultSort(AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING))
            ->paginate($this->getPerPage());
    }

    public static function filterByDateConditions(LaravelQueryBuilder $query, Carbon $today): LaravelQueryBuilder
    {
        $today = $today->startOfDay();
        return $query->where(function (LaravelQueryBuilder $query) use ($today) {
            $query->where('organization_transfers.start_date', '<=', $today)
                ->where('organization_transfers.end_date', '>=', $today);
        })
            ->orWhere(function (LaravelQueryBuilder $query) use ($today) {
                $query->whereNull('organization_transfers.start_date')
                    ->where('organization_transfers.end_date', '>=', $today);
            })
            ->orWhere(function (LaravelQueryBuilder $query) use ($today) {
                $query->where('organization_transfers.start_date', '<=', $today)
                    ->whereNull('organization_transfers.end_date');
            });
    }

    public static function filterByMajorHistoryConditions(LaravelQueryBuilder $query, Carbon $today): LaravelQueryBuilder
    {
        return $query->where('organization_transfers.major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES);
    }

    private function firstTransferQuery(Carbon $today, bool $isFilterByUnit = false): Builder
    {
        $query = Transfer::query()
            ->whereColumn('organization_transfers.employee_id', 'organization_employees.id')
            ->where(function (Builder $query) use ($today) {
                $this->filterByDateConditions($query->getQuery(), $today);
            });

        if ($isFilterByUnit) {
            $filterBy = request('filter');
            $query = $query->where($filterBy);
        }
        return $query->orderBy('organization_transfers.start_date')
            ->limit(1);
    }

    private function firstTransferMajorHistoryQuery(): Builder
    {
        return Transfer::query()
            ->whereColumn('organization_transfers.employee_id', 'organization_employees.id')
            ->where('organization_transfers.major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES)
            ->orderByDesc('organization_transfers.updated_at')
            ->limit(1);
    }

    private function queryTransferJoinTable(Builder $query, string $modelClass, string $joinKey, string $selectColumn = 'long_name'): Builder
    {
        $tableName = app($modelClass)->getTable();
        $column = $tableName . '.' . $selectColumn;
        return $query->select($column)
            ->leftJoin($tableName, 'organization_transfers.' . $joinKey, '=', $tableName . '.id');
    }

    public function findAll(): Collection|array
    {
        $today = Carbon::now();
        $transferQuery = $this->firstTransferQuery($today, true);

        return QueryBuilder::for($this->model())
            ->join('organization_transfers', function (JoinClause $join) use ($today) {
                $join->on('organization_employees.id', '=', 'organization_transfers.employee_id')
                    ->where(function (JoinClause $query) use ($today) {
                        $this->filterByDateConditions($query, $today);
                    });
            })
            ->addSelect([
                'transfer_position' => $transferQuery->clone()->select('organization_transfers.position'),
                'transfer_represent_flg' => $transferQuery->clone()->select('organization_transfers.represent_flg'),
                'count_favorites' => self::getCountFavoriteQuery($this->model())
            ])
            ->where('organization_employees.use_classification', UseFlagEnum::USE)
            ->with(['transfers' => function (HasMany $query) use ($today) {
                $filterBy = request('filter');
                $query->with(['company', 'site', 'department', 'division'])
                    ->where(function (Builder $query) use ($today) {
                        $this->filterByDateConditions($query->getQuery(), $today);
                    })
                    ->where($filterBy)
                    ->orderBy('organization_transfers.start_date')->limit(1);
            }])
            ->groupBy(Employee::$selectProps)
            ->allowedFilters([
                AllowedFilter::custom('company_id', new FilterByCompanyId()),
                AllowedFilter::custom('site_id', new FilterBySiteId()),
                AllowedFilter::custom('department_id', new FilterByDepartmentId()),
                AllowedFilter::custom('division_id', new FilterByDivisionId()),
            ])
            ->allowedSorts([
                ...$this->allowedSorts,
                AllowedSort::custom('code', new SortByEmployeeCode())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('represent_flg', new SortByRepresentFlg())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('position', new SortByPosition)->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING),
                AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
            ])
            ->defaultSort(AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING))
            ->get();
    }

    public function showDetail(Employee $employee): Model|QueryBuilder
    {
        return $employee->load(['createdBy', 'updatedBy']);
    }

    /**
     * @throws Throwable
     */
    public function createEmployee(array $attributes): Model|Employee|null
    {
        DB::beginTransaction();
        try {
            $employee = $this->create($attributes);
            $employee->transfers()->createMany([
                [
                    'company_id' => $attributes['company_id'],
                    'site_id' => $attributes['site_id'] ?? null,
                    'department_id' => $attributes['department_id'] ?? null,
                    'division_id' => $attributes['division_id'] ?? null,
                    'start_date' => Carbon::now()
                ]
            ]);
            DB::commit();
            return $employee;
        } catch (\Exception $e) {
            DB::rollback();
            return null;
        }
    }

    public function findEmployeeSocial(): Collection
    {
        $system = System::where('code', SystemCodeEnum::SOCIAL)->firstOrFail();
        return Employee::query()
            ->whereHas('accessPermissions', function (Builder $query) use ($system) {
                $query->where('system_id', $system->id);
                $query->where('permission_1', '<>', Permission1FlagEnum::UN_AUTHORIZED_USER);
            })
            ->where('use_classification', UseFlagEnum::USE)
            ->orderBy($this->defaultSort)
            ->select(Employee::$selectProps)->get();
    }

    public function findSupplierPerson(EmployeeSupplierQuery $query): Collection
    {
        return $query->where('use_classification', UseFlagEnum::USE)
            ->orderBy($this->defaultSort)
            ->select(Employee::$selectProps)->get();
    }

    public function selectEmployeeSocialCustomer(): LengthAwarePaginator
    {
        $transferMajorHistoryQuery = $this->firstTransferMajorHistoryQuery();
        return QueryBuilder::for($this->model())
            ->select(Employee::$selectProps)
            ->addSelect([
                'company_name' => $this->queryTransferJoinTable($transferMajorHistoryQuery->clone(), Company::class, 'company_id'),
                'company_display_order' => $this->queryTransferJoinTable($transferMajorHistoryQuery->clone(), Company::class, 'company_id', 'display_order'),
                'company_company_classification' => $this->queryTransferJoinTable($transferMajorHistoryQuery->clone(), Company::class, 'company_id', 'company_classification'),
                'site_display_order' => $this->queryTransferJoinTable($transferMajorHistoryQuery->clone(), Site::class, 'site_id', 'display_order'),
                'department_display_order' => $this->queryTransferJoinTable($transferMajorHistoryQuery->clone(), Department::class, 'department_id', 'display_order'),
                'division_display_order' => $this->queryTransferJoinTable($transferMajorHistoryQuery->clone(), Division::class, 'division_id', 'display_order'),
                'transfer_position' => $transferMajorHistoryQuery->clone()->select('position'),
            ])
            ->whereHas('transfers', function (Builder $query) {
                $query->where('organization_transfers.major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES);
            })
            ->with(['transfers' => function (HasMany $query) {
                $query->with(['company', 'site', 'department', 'division'])
                    ->where(function (Builder $query) {
                        $query->where('organization_transfers.major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES);

                    })->orderByDesc('organization_transfers.updated_at')->limit(1);
            }])
            ->where('use_classification', UseFlagEnum::USE)
            ->whereNotIn('organization_employees.id', function (LaravelQueryBuilder $query) {
                $query->select('employee_id')->from('social_customers');
            })
            ->allowedFilters([
                AllowedFilter::custom('name', new FilterByEmployeeNameCustomer()),
                AllowedFilter::custom('company_classification', new FilterByCompanyClassification()),
                AllowedFilter::custom('affiliated_company_id', new FilterByCompanyIdSelect()),
            ])
            ->allowedSorts([
                AllowedSort::custom('name', new SortByEmployeeKana())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('company_classification', new SortByCompanyClassification())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('company', new SortByCompanyDisplay())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('site', new SortBySiteDisplay())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('department', new SortByDepartmentDisplay())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('division', new SortByDivisionDisplay())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('position', new SortByPositionSelectEmployee())->defaultDirection(SortDirection::DESCENDING),
            ])
            ->defaultSort([AllowedSort::custom('name', new SortByEmployeeKana())->defaultDirection(SortDirection::ASCENDING)])
            ->groupBy(Employee::$selectProps)
            ->paginate($this->getPerPage());
    }

    public function dropdownCompanySelectEmployee(): Collection
    {
        return QueryBuilder::for($this->model())
            ->addSelect(Company::$selectProps)->distinct()
            ->join('organization_transfers', function (JoinClause $join) {
                $join->on('organization_employees.id', '=', 'organization_transfers.employee_id')
                    ->where('organization_transfers.major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES);
            })
            ->join('organization_companies', function (JoinClause $join) {
                $join->on('organization_transfers.company_id', '=', 'organization_companies.id');
            })
            ->where('organization_employees.use_classification', UseFlagEnum::USE)
            ->whereNotIn('organization_employees.id', function (LaravelQueryBuilder $query) {
                $query->select('employee_id')->from('social_customers');
            })
            ->get();
    }

    public function checkRelations(Employee $employee): Model|Employee
    {
        return QueryBuilder::for($this->model())
            ->withCount('transfers')
            ->withCount('customer')
            ->withCount('customerResponsive')
            ->withCount('managementGroupPreparatoryPersonnel')
            ->withCount('managementGroupApplicant')
            ->withCount('managementGroupApprover')
            ->withCount('managementGroupFinalDecisionMaker')
            ->withCount('managementGroupOrderingPersonnel')
            ->withCount('managementGroupPaymentPersonnel')
            ->withCount('managementGroupCompletionPersonnel')
            ->withCount('managementGroupApplicant')
            ->withCount('supplierPerson')
            ->withCount('supplierCompanyPerson')
            ->withCount('clientEmployees')
            ->withCount('managementDepartmentEmployees')
            ->withCount('counterpartyContractor')
            ->withCount('counterpartyRepresentative')
            ->withCount('contractor')
            ->withCount('representative')
            ->find($employee->id);
    }

    public function getSocialResponsibleEmployee(): Collection
    {
        $employeeIds = Customer::select('responsible_id');

        return Employee::query()->whereIn('id', $employeeIds)
            ->orWhereIn('id', collect([Auth::user()->employee_id]))->get();
    }
}
