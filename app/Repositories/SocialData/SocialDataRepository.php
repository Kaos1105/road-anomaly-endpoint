<?php

namespace App\Repositories\SocialData;

use App\Enums\Common\UseFlagEnum;
use App\Enums\Transfer\MajorHistoryEnum;
use App\Enums\Workflow\ExecutionEndEnum;
use App\Enums\Workflow\ExecutionOrderEnum;
use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\Customer;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Transfer;
use App\Models\Workflow;
use App\Repositories\AccessPermission\AccessPermissionRepository;
use App\Repositories\SocialData\Filter\FilterByCustomerCategory;
use App\Repositories\SocialData\Filter\FilterByCustomerResponsible;
use App\Repositories\SocialData\Filter\FilterByOrderDate;
use App\Repositories\SocialData\Filter\FilterBySupplierId;
use App\Repositories\Transfer\Sort\SortByCompany;
use App\Repositories\Transfer\Sort\SortByDepartment;
use App\Repositories\Transfer\Sort\SortByDivision;
use App\Repositories\Transfer\Sort\SortByNo;
use App\Repositories\Transfer\Sort\SortByPeriod;
use App\Repositories\Transfer\Sort\SortByPosition;
use App\Repositories\Transfer\Sort\SortBySite;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class SocialDataRepository extends BaseRepository implements ISocialDataRepository
{
    use HasPagination;

    public function model(): string
    {
        return SocialData::class;
    }

    protected string $defaultSort = 'data_progress';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('social_event_id'),
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('data_progress'),
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
            AllowedFilter::custom('customer_category', new FilterByCustomerCategory()),
            AllowedFilter::custom('customer_responsible_id', new FilterByCustomerResponsible()),
        ];
    }

    protected array $allowedSorts = [
        'updated_at',
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
            ->select(SocialData::$selectProps);
    }

    public function getList(): Collection
    {
        return $this->filters()->get();
    }

    public function showEditDetail(SocialData $detail): SocialData
    {
        return $detail->load(['createdBy', 'updatedBy',
            'socialEvent.eventClassification',
            'product.site.company',
            'customer' => function (BelongsTo $customerQuery) {
                $customerQuery->with(
                    [
//                        'employee' => function (BelongsTo $employeeQuery) {
//                            $employeeQuery->with(['transfers' => function (HasMany $transferQuery) {
//                                $transferQuery->where('major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES)
//                                    ->with(['company', 'site', 'department', 'division'])->orderBy('start_date');
//                            }]);
//                        },
                        'responsibleEmployee' => function (BelongsTo $responsibleQuery) {
                            $responsibleQuery->with(['transfers' => function (HasMany $transferQuery) {
                                $now = Carbon::now();
                                $latestTransferId = $transferQuery->clone()->select('id')
                                    ->orderByDesc('organization_transfers.updated_at')->limit(1);
                                $transferQuery->where('organization_transfers.id', $latestTransferId);
                                AccessPermissionRepository::filterTransferByDateConditions($transferQuery->getQuery(), $now)
                                    ->with(['department']);
                            }]);
                        },
                    ]);
            },
            'displayTransfer' => function (BelongsTo $transferQuery) {
                $transferQuery->with(['employee', 'company', 'site', 'department', 'division']);
            },
            'accountingDepartment'
        ]);
    }

    public function showDisplayDetail(SocialData $detail): SocialData
    {
        return $this->showEditDetail($detail)->load(['product.site.company',
            'workflows' => function (HasMany $workFlowQuery) {
                $workFlowQuery->with(['scheduledPerson', 'executor']);
            }
        ]);
    }

    public function getSocialDataByCustomer(Customer $customer): Collection
    {
        return QueryBuilder::for($this->model())
            ->join('social_social_events', 'social_social_datas.social_event_id', '=', 'social_social_events.id')
            ->where('social_social_datas.use_classification', '=', UseFlagEnum::USE)
            ->where('social_social_datas.customer_id', '=', $customer->id)
            ->with([
                'socialEvent.eventClassification',
                'product' => function (BelongsTo $productQuery) {
                    $productQuery->with(['site.company', 'supplier']);
                },
                'displayTransfer' => function (BelongsTo $transferQuery) {
                    $transferQuery->with(['employee', 'company', 'site', 'department', 'division']);
                },
                'customer' => function (BelongsTo $customerQuery) {
                    $customerQuery->with(['responsibleEmployee']);
                },
                'accountingDepartment',
                'workflows'
            ])
            ->orderByDesc('social_social_events.planned_start')
            ->get(SocialData::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->with([
                'socialEvent.eventClassification',
                'product' => function (BelongsTo $productQuery) {
                    $productQuery->with(['site.company', 'supplier']);
                },
                'displayTransfer' => function (BelongsTo $transferQuery) {
                    $transferQuery->with(['employee', 'company', 'site', 'department', 'division']);
                },
                'customer' => function (BelongsTo $customerQuery) {
                    $customerQuery->with(['responsibleEmployee']);
                },
                'accountingDepartment',
                'workflows'
            ])
            ->paginate($this->getPerPage());
    }

    public function getLatestNonPendingWorkflow(SocialData $socialData): Workflow|null
    {
        return Workflow::where('social_data_id', $socialData->id)
            ->where('execution_type', '!=', ExecutionEndEnum::UNPROCESS)
            ->orderByDesc('workflow_order')
            ->first();
    }

    public function getShippingInfo(SocialData $detail): SocialData
    {
        return $detail->load(['customer',
            'displayTransfer' => function (BelongsTo $transferQuery) {
                $transferQuery->with(['employee', 'company', 'site', 'department', 'division']);
            },
        ]);
    }

    public function getSocialEventOrderedDate(SocialEvent $socialEvent): Collection
    {
        return Workflow::whereHas('socialData', function (Builder $query) use ($socialEvent) {
            $query->where('social_event_id', $socialEvent->id);
        })->where([
            'workflow_order' => WorkflowOrderEnum::ORDER,
            'execution_type' => ExecutionOrderEnum::ORDERED
        ])->whereNotNull('social_workflows.execution_at')->orderByDesc('social_workflows.execution_at')
            ->select(Workflow::$selectProps)->get();
    }

    public function getPaginateDataBySocialEvent(SocialEvent $socialEvent): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                AllowedFilter::custom('supplier_id', new FilterBySupplierId()),
                AllowedFilter::custom('order_date', new FilterByOrderDate())->default(""),
            ])
//            ->whereHas('workflows', function (EloquentBuilder $workflowQuery) {
//                $workflowQuery->where([
//                    'workflow_order' => WorkflowOrderEnum::ORDER,
//                    'execution_type' => ExecutionOrderEnum::ORDERED
//                ]);
//            })
            ->where('social_event_id', $socialEvent->id)
            ->with([
                'customer.responsibleEmployee',
                'displayTransfer' => function (BelongsTo $transferQuery) {
                    $transferQuery->with(['employee', 'company', 'site', 'department', 'division']);
                },
                'product',
                'accountingDepartment',
                'workflows'
            ])
            ->select(SocialData::$selectProps)
            ->paginate($this->getPerPage());
    }

    public function getMajorTransfers(SocialData $detail): Collection
    {
        $employeeId = $detail->customer->employee_id;

        return QueryBuilder::for(Transfer::class)
            ->where('major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES)
            ->where('employee_id', '=', $employeeId)
            ->allowedSorts([
                ...$this->allowedSorts,
                AllowedSort::custom('no', new SortByNo())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('start_date', new SortByPeriod())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('company', new SortByCompany())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('site', new SortBySite())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('department', new SortByDepartment())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('division', new SortByDivision())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('position', new SortByPosition())->defaultDirection(SortDirection::ASCENDING)
            ])
            ->select(Transfer::$selectProps)
            ->defaultSort(AllowedSort::custom('no', new SortByNo())->defaultDirection(SortDirection::ASCENDING))
            ->with(['company', 'site', 'department', 'division'])->orderBy('start_date')
            ->get();
    }

    public function getPaidSocialDataPastThreeYears(): Collection
    {
        $currentYear = Carbon::now()->year;
        return QueryBuilder::for(SocialData::class)
            ->whereHas('workflows', function (Builder $workflowQuery) use ($currentYear) {
                $workflowQuery->where([
                    'workflow_order' => WorkflowOrderEnum::PAYMENT,
                    'execution_type' => ExecutionPaymentEnum::PAID
                ])->where(function (Builder $subQuery) use ($currentYear) {
                    $subQuery->whereYear('execution_at', '<=', $currentYear)
                        ->whereYear('execution_at', '>=', $currentYear - 2);
                });
            })->with(['workflows'])->get();
    }

    public function getDashboardList(): Collection
    {
        $currentYear = Carbon::now()->year;
        return QueryBuilder::for(SocialData::class)
            ->whereHas('workflows', function (Builder $workflowQuery) use ($currentYear) {
                $workflowQuery->where([
                    'workflow_order' => WorkflowOrderEnum::PAYMENT,
                    'execution_type' => ExecutionPaymentEnum::PAID
                ])->where(function (Builder $subQuery) use ($currentYear) {
                    $subQuery->whereYear('execution_at', '<=', $currentYear)
                        ->whereYear('execution_at', '>=', $currentYear - 4);
                });
            })->with(['workflows'])->get();
    }
}
