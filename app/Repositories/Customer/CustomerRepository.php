<?php

namespace App\Repositories\Customer;

use App\Enums\Common\UseFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Transfer;
use App\Query\Customer\SocialDataUnRegisCustomerQuery;
use App\Repositories\Customer\Filter\FilterByAffiliatedCompanyId;
use App\Repositories\Customer\Filter\FilterByCustomerName;
use App\Repositories\Customer\Sort\SortByAccountingDepartment;
use App\Repositories\Customer\Sort\SortByAffiliatedCompany;
use App\Repositories\Customer\Sort\SortByCategoryName;
use App\Repositories\Customer\Sort\SortByCompanyName;
use App\Repositories\Customer\Sort\SortByCustomerName;
use App\Repositories\Customer\Sort\SortByDisplayOrder;
use App\Repositories\Customer\Sort\SortByPosition;
use App\Repositories\Customer\Sort\SortByResponsibleName;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerRepository extends BaseRepository implements ICustomerRepository
{
    use HasPagination;

    public function model(): string
    {
        return Customer::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('category_name'),
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('responsible_id'),
            AllowedFilter::exact('accounting_department_id'),
            AllowedFilter::exact('accounting_company'),
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
            AllowedFilter::custom('affiliated_company_id', new FilterByAffiliatedCompanyId()),
            AllowedFilter::custom('name', new FilterByCustomerName()),
        ];
    }

    protected array $allowedSorts = [
        'updated_at',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('category_name', new SortByCategoryName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('customer_name', new SortByCustomerName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('company_name', new SortByCompanyName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('affiliated_company', new SortByAffiliatedCompany())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('position', new SortByPosition())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('accounting_department', new SortByAccountingDepartment())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('responsible_name', new SortByResponsibleName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
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
            ->defaultSort(AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING))
            ->select(Customer::$selectProps);
    }

    public function getList(): Collection
    {
        return $this->filters()->get();
    }

    public function getAll(): Collection
    {
        return QueryBuilder::for($this->model())
            ->with([
                'responsibleEmployee',
                'accountingDepartment',
                'displayTransfer.company',
            ])
            ->select(Customer::$selectProps)->get();
    }

    public function showDetail(Customer $detail): Customer
    {
        return $detail->load([
            'createdBy',
            'updatedBy',
            'employee',
            'responsibleEmployee',
            'accountingDepartment',
            'displayTransfer',
            'displayTransfer.company',
            'displayTransfer.site',
            'displayTransfer.department',
            'displayTransfer.division',
            'socialData' => function (HasMany $socialDataQuery) {
                $socialDataQuery->with([
                    'product' => function (BelongsTo $productQuery) {
                        $productQuery->with(['site.company', 'supplier']);
                    },
                    'socialEvent.eventClassification',
                    'displayTransfer' => function (BelongsTo $transferQuery) {
                        $transferQuery->with(['company', 'site', 'department', 'division']);
                    },
                    'workflows'
                ])->whereHas('socialEvent', function (EloquentBuilder $socialEventQuery) use ($socialDataQuery) {
                    $socialEventQuery->where('use_classification', UseFlagEnum::USE);
                });
            }
        ]);
    }

    /**
     * @throws ValidatorException
     */
    public function createCustomer(array $dataInsert): Customer
    {
        $result = $this->create($dataInsert);
        return $this->showDetail($result);
    }

    /**
     * @throws ValidatorException
     */
    public function updateCustomer(array $dataUpdate, Customer $customer): Customer
    {
        $result = $this->update($dataUpdate, $customer->id);
        return $this->showDetail($result);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->with([
            'employee',
            'responsibleEmployee',
            'accountingDepartment',
            'displayTransfer',
            'displayTransfer.company',
            'displayTransfer.site',
            'displayTransfer.department',
            'displayTransfer.division',
            'responsibleEmployee.accessPermissions' => function (HasMany $query) {
                $query->whereHas('system', function (EloquentBuilder $system) {
                    $system->where('code', SystemCodeEnum::SOCIAL);
                });
            }
        ])
            ->addSelect([
                'company_name' => $this->transferQuery('organization_companies', 'company_id'),
                'site_name' => $this->transferQuery('organization_sites', 'site_id')
            ])
            ->paginate($this->getPerPage());
    }

    private function transferQuery(string $joinTable, string $foreignKey): \Illuminate\Database\Eloquent\Builder
    {
        return Transfer::query()->select('long_name')
            ->leftJoin($joinTable, 'organization_transfers.' . $foreignKey, '=', $joinTable . '.id')
            ->whereColumn('organization_transfers.id', 'social_customers.display_transfer_id');
    }

    public function numberOfRecords(): int
    {
        return QueryBuilder::for($this->model())->count();
    }

    static function loadSocialCustomerRelation(QueryBuilder $query, SocialEvent $socialEvent): QueryBuilder
    {
        return $query->with([
            'employee',
            'responsibleEmployee',
            'displayTransfer' => function (BelongsTo $transferQuery) use ($socialEvent) {
                $transferQuery->with([
                    'company', 'site', 'department', 'division',
                ]);
            },
            'socialData' => function (HasMany $socialDataQuery) use ($socialEvent) {
                $socialDataQuery->with([
                    'product' => function (BelongsTo $productQuery) {
                        $productQuery->with(['site.company', 'supplier']);
                    }
                ])->whereHas('socialEvent', function (EloquentBuilder $eventQuery) use ($socialEvent) {
                    $eventQuery->where('event_id', '=', $socialEvent->event_id);
                })->orderByDesc('social_social_datas.id')->limit(2);
            }
        ])->select(Customer::$selectProps);
    }

    public function getUnRegisCustomers(SocialEvent $socialEvent, SocialDataUnRegisCustomerQuery $query): LengthAwarePaginator
    {
        $existedCustomerIds = SocialData::query()->where('social_event_id', '=', $socialEvent->id)
            ->select('customer_id');
        $customerCategoryNames = CustomerCategory::query()->where('group_id', $socialEvent->group_id)
            ->select('name');
        $customerQuery = $query->whereNotIn('id', $existedCustomerIds)
            ->whereIn('category_name', $customerCategoryNames)
            ->where('use_classification', UseFlagEnum::USE);

        return self::loadSocialCustomerRelation($customerQuery, $socialEvent)
            ->orderBy('social_customers.category_name')
            ->paginate($this->getPerPage());
    }

    public function getRegisteringCustomerSocialData(SocialEvent $socialEvent, array $customerIds): Collection
    {
        $customerQuery = QueryBuilder::for($this->model())->whereIn('id', $customerIds);

        return $customerQuery->with([
            'socialData' => function (HasMany $socialDataQuery) use ($socialEvent) {
                $socialDataQuery->whereHas('socialEvent', function (EloquentBuilder $eventQuery) use ($socialEvent) {
                    $eventQuery->where('event_id', '=', $socialEvent->event_id);
                })->orderByDesc('social_social_datas.id')->limit(2);
            }
        ])->select(Customer::$selectProps)->get();
    }

    public function checkRelations(Customer $customer): Customer|Model
    {
        return QueryBuilder::for($this->model())
            ->withCount('socialData')
            ->find($customer->id);
    }
}
