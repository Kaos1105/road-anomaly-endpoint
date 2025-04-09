<?php

namespace App\Repositories\SocialEvent;

use App\Enums\Common\UseFlagEnum;
use App\Enums\SocialEvent\EventProgressClassificationEnum;
use App\Enums\Workflow\ExecutionOrderEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\SocialEvent;
use App\Repositories\SocialEvent\Sort\SortByCustomerCount;
use App\Repositories\SocialEvent\Sort\SortByEventClassificationName;
use App\Repositories\SocialEvent\Sort\SortByEventProgress;
use App\Repositories\SocialEvent\Sort\SortByEventTitle;
use App\Repositories\SocialEvent\Sort\SortByManagementGroupName;
use App\Repositories\SocialEvent\Sort\SortByPaymentCount;
use App\Repositories\SocialEvent\Sort\SortByPaymentTotal;
use App\Repositories\SocialEvent\Sort\SortByPlannedCompletion;
use App\Repositories\SocialEvent\Sort\SortByPlannedStart;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as BuilderQuery;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class SocialEventRepository extends BaseRepository implements ISocialEventRepository
{
    use HasPagination;

    public function model(): string
    {
        return SocialEvent::class;
    }

    protected string $defaultSort = 'planned_start';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('group_id'),
            AllowedFilter::exact('event_id'),
            AllowedFilter::exact('event_progress'),
            AllowedFilter::exact('use_classification'),
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
            AllowedSort::custom('event_title', new SortByEventTitle())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('group_name', new SortByManagementGroupName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('event_classification_name', new SortByEventClassificationName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('planned_start', new SortByPlannedStart())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('planned_completion', new SortByPlannedCompletion())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('event_progress', new SortByEventProgress())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('customer_count', new SortByCustomerCount())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('payment_count', new SortByPaymentCount())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('payment_total', new SortByPaymentTotal())->defaultDirection(SortDirection::ASCENDING),
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
            ->select(SocialEvent::$selectProps);
    }

    public function getList(): Collection
    {
        return $this->filters()->get();
    }

    public function showDetail(SocialEvent $detail): SocialEvent
    {
        return $detail->load(['createdBy', 'updatedBy', 'eventClassification', 'managementGroup',
            'socialData' => function (HasMany $socialDataQuery) {
                $socialDataQuery->with(['customer.responsibleEmployee', 'workflows']);
            }
        ]);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->whereHas('eventClassification', function (Builder $query) {
                $query->where('use_classification', UseFlagEnum::USE);
            })
            ->whereHas('managementGroup', function (Builder $query) {
                $query->where('use_classification', UseFlagEnum::USE);
            })
            ->addSelect(
                [
                    'customer_count' => function (BuilderQuery $query) {
                        $query->selectRaw('count(distinct social_social_datas.id)')
                            ->from('social_social_datas')
                            ->whereColumn('social_social_datas.social_event_id', 'social_social_events.id');
                    },
                    'payment_count' => function (BuilderQuery $query) {
                        $this->paidSocialDataQuery($query)->selectRaw('count(distinct social_social_datas.id)');
                    },
                    'payment_total' => function (BuilderQuery $query) {
                        $this->paidSocialDataQuery($query)->selectRaw('sum(social_social_datas.total_amount)');
                    },
                ]
            )->with(['eventClassification', 'managementGroup', 'socialData.workflows'])->paginate($this->getPerPage());
    }

    public function paidSocialDataQuery(BuilderQuery $query): BuilderQuery
    {
        return $query->from('social_social_datas')
            ->whereColumn('social_social_datas.social_event_id', 'social_social_events.id')
            ->leftJoin('social_workflows', 'social_social_datas.id', '=', 'social_workflows.social_data_id')
            ->where([
                'social_workflows.workflow_order' => WorkflowOrderEnum::ORDER,
                'social_workflows.execution_type' => ExecutionOrderEnum::ORDERED
            ]);
    }

    public function showSocialDataEventDetail(SocialEvent $detail): SocialEvent
    {
        return $detail->load(['eventClassification', 'managementGroup', 'socialData.workflows']);
    }

    public function showSocialEventWithSupplier(SocialEvent $detail): SocialEvent
    {
        $filter = request('filter');
        $supplierId = $filter && !empty($filter['supplier_id']) ? $filter['supplier_id'] : null;
        $orderDate = $filter && !empty($filter['order_date']) ? $filter['order_date'] : null;

        return $detail->load(['socialData' => function (HasMany $socialDataQuery) use ($supplierId, $orderDate) {
            $socialDataQuery->whereHas('workflows', function (Builder $workflowQuery) use ($orderDate) {
                $workflowQuery->where([
                    'workflow_order' => WorkflowOrderEnum::ORDER,
                    'execution_type' => ExecutionOrderEnum::ORDERED
                ]);
                if ($orderDate) {
                    $workflowQuery->whereDate('social_workflows.execution_at', $orderDate);
                }
            })->whereHas('product', function (Builder $productQuery) use ($supplierId) {
                $productQuery->where('supplier_id', $supplierId);
            });
        }]);
    }

    public function checkRelations(SocialEvent $socialEvent): Model|SocialEvent
    {
        return QueryBuilder::for($this->model())
            ->withCount('socialData')
            ->find($socialEvent->id);
    }


    public function numberOfRecords(): int
    {
        return QueryBuilder::for($this->model())->count();
    }

    public function getDashboardList(): Collection
    {
        $januaryPreviousYear = Carbon::now()->startOfYear()->subYear();

        return QueryBuilder::for($this->model())->with('managementGroup')
            ->where('planned_completion', '>=', $januaryPreviousYear)
            ->where(function (Builder $query) {
                $query->where([
                    'use_classification' => UseFlagEnum::NOT_USE,
                    'event_progress' => EventProgressClassificationEnum::IN_PREPARATION
                ])->orWhere(
                    function (Builder $query) {
                        $query->where([
                            'use_classification' => UseFlagEnum::USE,
                            'event_progress' => EventProgressClassificationEnum::UNDER_WAY
                        ]);
                    }
                )->orWhere(function (Builder $query) {
                    $query->where([
                        'use_classification' => UseFlagEnum::USE,
                        'event_progress' => EventProgressClassificationEnum::COMPLETED
                    ]);
                });
            })->select(SocialEvent::$selectProps)->orderByDesc($this->defaultSort)->get();
    }
}
