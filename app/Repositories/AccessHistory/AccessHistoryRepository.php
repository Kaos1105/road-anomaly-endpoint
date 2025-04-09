<?php

namespace App\Repositories\AccessHistory;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\AccessHistory\ResultClassificationEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Enums\System\SystemCodeEnum;
use App\Enums\Transfer\MajorHistoryEnum;
use App\Models\AccessHistory;
use App\Models\Customer;
use App\Models\PersonalAccessToken;
use App\Models\System;
use App\Repositories\AccessHistory\Filter\FilterByAction;
use App\Repositories\AccessHistory\Sort\SortByAccessibleType;
use App\Repositories\AccessHistory\Sort\SortByAccessTime;
use App\Repositories\AccessHistory\Sort\SortByAction;
use App\Repositories\AccessHistory\Sort\SortByMessage;
use App\Repositories\AccessHistory\Sort\SortByResultClassification;
use App\Repositories\AccessHistory\Sort\SortBySystemDisplayOrder;
use App\Repositories\AccessHistory\Sort\SortByUserDisplayOrder;
use App\Repositories\AccessPermission\AccessPermissionRepository;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class AccessHistoryRepository extends BaseRepository implements IAccessHistoryRepository
{
    use HasPagination;

    public function model(): string
    {
        return AccessHistory::class;
    }

    protected string $defaultSort = '-access_at';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('system_id'),
            AllowedFilter::exact('accessible_type'),
            AllowedFilter::exact('employee_id'),
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
            AllowedFilter::custom('action', new FilterByAction())
        ];
    }

    protected array $allowedSorts = [
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
            ->select(AccessHistory::$selectProps);
    }

    public function findAll(int $numberRecords): Collection
    {
        return $this->filters()->with('employee')->limit($numberRecords)->get();
    }

    public function findLoginSNETDashboard(int $numberRecords): Collection
    {
        return $this->filters()
            ->where(['result_classification' => ResultClassificationEnum::OK])
            ->with('employee')
            ->limit($numberRecords)->get();
    }

    public function findTopicDashboard(int $numberRecords): Collection
    {
        return $this->filters()
            ->where([
                'action' => AccessActionTypeEnum::START,
                'result_classification' => ResultClassificationEnum::OK,
            ])
            ->with(['employee', 'accessible'])->limit($numberRecords)->get();
    }

    public function findCompany(int $numberRecords): \Illuminate\Support\Collection
    {
        $organizationSystemId = $this->getSystemId(SystemCodeEnum::ORGANIZATION);
        if (!$organizationSystemId) {
            return collect();
        }
        return $this->filters()->where([
            'system_id' => $organizationSystemId,
            'accessible_type' => AccessibleTypeEnum::COMPANY,
            'result_classification' => ResultClassificationEnum::OK,
        ])->with(['accessible'])->limit($numberRecords)->get();
    }

    private function getSystemId(string $systemCode): int|null
    {
        $organizationSystem = System::whereCode($systemCode)->firstOrFail();
        return $organizationSystem?->id;
    }

    public function findEmployees(int $numberRecords, bool $isShinichiro = false): \Illuminate\Support\Collection
    {
        $organizationSystemId = $this->getSystemId(SystemCodeEnum::ORGANIZATION);
        if (!$organizationSystemId) {
            return collect();
        }
        return $this->filters()->where([
            'system_id' => $organizationSystemId,
            'accessible_type' => AccessibleTypeEnum::EMPLOYEE,
            'result_classification' => ResultClassificationEnum::OK,
        ])
            ->when($isShinichiro, function (Builder $query) {
                $query->whereHasMorph('accessible', AccessibleTypeEnum::EMPLOYEE, function (Builder $query) {
                    $query->where(function (Builder $transferQuery) {
                        $transferQuery->whereHas('transfers', function (Builder $nestedQuery) {
                            AccessPermissionRepository::filterTransferByDateConditions($nestedQuery, Carbon::now());
                            $nestedQuery->whereHas('company', function (Builder $companyQuery) {
                                $companyQuery->where('company_classification', CompanyClassificationEnum::SHINNICHIRO);
                            });
                        });
                    });
                });
            })
            ->with(['employee', 'accessible', 'accessible.transfers' => function (HasMany $transferQuery) use ($isShinichiro) {
                AccessPermissionRepository::filterTransferByDateConditions($transferQuery->getQuery(), Carbon::now());
                if ($isShinichiro) {
                    $transferQuery->whereHas('company', function (Builder $companyQuery) {
                        $companyQuery->where('company_classification', CompanyClassificationEnum::SHINNICHIRO);
                    });
                    $transferRelationship = ['employee', 'company', 'department', 'division'];
                } else {
                    $transferQuery->where('major_history_flg', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES);
                    $transferRelationship = ['employee', 'company'];
                }
                $transferQuery->with($transferRelationship)
                    ->orderBy('start_date')
                    ->limit(1);
            }])
            ->limit($numberRecords)->get();
    }


    public function findSupplierSocialDashboard(int $numberRecords): Collection
    {
        return $this->filters()
            ->where([
                'accessible_type' => AccessibleTypeEnum::SUPPLIER,
                'result_classification' => ResultClassificationEnum::OK,
            ])
            ->with(['employee', 'accessible'])->limit($numberRecords)->get();
    }

    public function findCustomerSocialDashboard(int $numberRecords): Collection
    {
        return $this->filters()
            ->where([
                'accessible_type' => AccessibleTypeEnum::CUSTOMER,
                'result_classification' => ResultClassificationEnum::OK,
            ])
            ->with(['employee', 'accessible' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Customer::class => ['employee']
                ]);
            }])->limit($numberRecords)->get();
    }

    public function findProductSocialDashboard(int $numberRecords): Collection
    {
        return $this->filters()
            ->where([
                'accessible_type' => AccessibleTypeEnum::PRODUCT,
                'result_classification' => ResultClassificationEnum::OK,
            ])
            ->with(['employee', 'accessible'])->limit($numberRecords)->get();
    }

    public function findEditUserPermissionSetting(int $numberRecords): Collection
    {
        return $this->filters()
            ->where([
                'action' => AccessActionTypeEnum::EDIT,
                'accessible_type' => AccessibleTypeEnum::ACCESS_PERMISSION,
                'result_classification' => ResultClassificationEnum::OK,
            ])
            ->with(['employee', 'accessible'])->limit($numberRecords)->get();
    }

    public function findManagementDepartmentDashboard(int $numberRecords): Collection
    {
        return $this->filters()
            ->where([
                'accessible_type' => AccessibleTypeEnum::MANAGEMENT_DEPARTMENT,
                'result_classification' => ResultClassificationEnum::OK
            ])
            ->with(['employee', 'accessible'])->limit($numberRecords)->get();
    }

    public function findClientSiteDashboard(int $numberRecords): Collection
    {
        return $this->filters()
            ->where([
                'accessible_type' => AccessibleTypeEnum::CLIENT_SITE,
                'result_classification' => ResultClassificationEnum::OK
            ])
            ->with(['employee', 'accessible'])->limit($numberRecords)->get();
    }

    public function findNegotiationHistoryDashboard(int $numberRecords): Collection
    {
        return $this->filters()
            ->where([
                'accessible_type' => AccessibleTypeEnum::NEGOTIATION,
                'result_classification' => ResultClassificationEnum::OK
            ])
            ->with(['employee', 'accessible'])->limit($numberRecords)->get();
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model())
            ->leftJoin('organization_employees', function (JoinClause $join) {
                $join->on('organization_employees.id', '=', 'snet_access_histories.employee_id');
            })
            ->leftJoin('snet_systems', function (JoinClause $join) {
                $join->on('snet_systems.id', '=', 'snet_access_histories.system_id');
            })
            ->select(AccessHistory::$selectProps)
            ->allowedFilters([
                ...$this->allowedExactFilters(),
                AllowedFilter::exact('action'),
                AllowedFilter::exact('result_classification')
            ])
            ->allowedSorts([
                ...$this->allowedSorts,
                AllowedSort::custom('access_at', new SortByAccessTime())->defaultDirection(SortDirection::DESCENDING),
                AllowedSort::custom('user_order', new SortByUserDisplayOrder())->defaultDirection(SortDirection::DESCENDING),
                AllowedSort::custom('system_order', new SortBySystemDisplayOrder())->defaultDirection(SortDirection::DESCENDING),
                AllowedSort::custom('data', new SortByAccessibleType())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('action', new SortByAction())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('result_classification', new SortByResultClassification())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('message', new SortByMessage())->defaultDirection(SortDirection::ASCENDING),
            ])
            ->defaultSort($this->defaultSort)
            ->with(['employee', 'accessible', 'system'])
            ->paginate($this->getLargePerPage());
    }

    public function findAccessHistoryBySystem(System $system, array $accessibleTypes, int $numberRecords): Collection
    {
        return QueryBuilder::for($this->model())
            ->where([
                'system_id' => $system->id,
                'result_classification' => ResultClassificationEnum::OK
            ])
            ->whereIn('action', [AccessActionTypeEnum::CREATE, AccessActionTypeEnum::EDIT, AccessActionTypeEnum::DELETE])
            ->where(function (Builder $accessibleQuery) use ($accessibleTypes, $system) {
                $accessibleQuery->whereIn('accessible_type', $accessibleTypes);
                if ($system->code == SystemCodeEnum::SNET) {
                    $accessibleQuery->orWhere('accessible_type', AccessibleTypeEnum::ACCESS_PERMISSION);
                }
            })
            ->with(['employee', 'accessible'])
            ->orderByDesc('id')
            ->limit($numberRecords)->get();
    }

    public function findAnnouncementHistoryBySystemId(int $systemId, int $numberRecords): Collection
    {
        return QueryBuilder::for($this->model())
            ->where([
                'system_id' => $systemId,
                'accessible_type' => AccessibleTypeEnum::ANNOUNCEMENTS,
                'result_classification' => ResultClassificationEnum::OK,
            ])
            ->whereIn('action', [AccessActionTypeEnum::CREATE, AccessActionTypeEnum::EDIT, AccessActionTypeEnum::DELETE])
            ->with(['employee', 'accessible'])
            ->orderByDesc('id')
            ->limit($numberRecords)->get();
    }

    public function getTwoLastLoginHistory(): Collection
    {
        $employeeId = \Auth::user()->employee_id;
        return AccessHistory::where([
            'action' => AccessActionTypeEnum::LOGIN,
            'result_classification' => ResultClassificationEnum::OK,
            'employee_id' => $employeeId,
        ])
            ->orderByDesc('access_at')
            ->limit(2)->get();
    }

    public function countAccessPortalDuringLogin(int $systemId): int
    {
        $auth = \Auth::user();
        $accessToken = $auth->currentAccessToken();
        /**
         * @var PersonalAccessToken $accessToken
         */
        return AccessHistory::where([
            'action' => AccessActionTypeEnum::START,
            'employee_id' => $auth->employee_id,
            'result_classification' => ResultClassificationEnum::OK,
            'system_id' => $systemId,
        ])->whereBetween('access_at', [$accessToken->created_at, $accessToken->updated_at])
            ->count();
    }

    public function getLastHistory(): QueryBuilder|AccessHistory|null
    {
        return QueryBuilder::for($this->model())->select(AccessHistory::$selectProps)->orderBy('access_at')->first();
    }

    public function countSystemEachMonthByYear(string $year, bool $isOKClassification): Collection|null
    {
        $query = QueryBuilder::for($this->model())
            ->select(
                'system_id',
                DB::raw('LOWER(DATE_FORMAT(access_at, "%b")) AS month'),
                DB::raw('COUNT(*) AS access_count')
            )
            ->where(DB::raw('YEAR(access_at)'), $year);
        if ($isOKClassification) {
            $query = $query->where('result_classification', 'OK');
        } else {
            $query = $query->where('result_classification', '<>', 'OK');
        }
        return $query->groupBy('system_id', 'month')
            ->orderBy('system_id')
            ->get();
    }

    public function countSystemByYears(array $years, bool $isOKClassification): Collection|null
    {
        $query = QueryBuilder::for($this->model())
            ->select(
                'system_id',
                DB::raw('YEAR(access_at) AS year'),
                DB::raw('COUNT(*) AS access_count')
            )
            ->whereIn(DB::raw('YEAR(access_at)'), $years);
        if ($isOKClassification) {
            $query = $query->where('result_classification', 'OK');
        } else {
            $query = $query->where('result_classification', '<>', 'OK');
        }
        return $query
            ->groupBy('system_id', 'year')
            ->orderBy('system_id')
            ->get();
    }

    public function countSystemsEmployeeId(string $year, bool $isOKClassification): Collection|null
    {
        $query = QueryBuilder::for($this->model())
            ->select(
                'system_id',
                'employee_id',
                DB::raw('COUNT(*) AS access_count')
            )
            ->where(DB::raw('YEAR(access_at)'), $year);
        if ($isOKClassification) {
            $query = $query->where('result_classification', 'OK');
        } else {
            $query = $query->where('result_classification', '<>', 'OK');
        }
        return $query
            ->groupBy('system_id', 'employee_id')
            ->orderBy('employee_id')
            ->get();
    }

    public function countAccessEachHour(string $year, bool $isOKClassification, int $daysInYear): Collection|null
    {
        $query = QueryBuilder::for($this->model())
            ->select(
                DB::raw('HOUR(access_at) AS hour'),
                DB::raw('ROUND(COUNT(*) / ' . $daysInYear . ', 1) AS access_count')
            )
            ->where(DB::raw('YEAR(access_at)'), $year);
        if ($isOKClassification) {
            $query = $query->where('result_classification', 'OK');
        } else {
            $query = $query->where('result_classification', '<>', 'OK');
        }
        return $query
            ->groupBy('hour')
            ->get();
    }
}
