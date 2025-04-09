<?php

namespace App\Repositories\Supplier;

use App\Enums\Workflow\ExecutionOrderEnum;
use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Supplier;
use App\Repositories\Supplier\Sort\SortByAddress;
use App\Repositories\Supplier\Sort\SortByCompanyName;
use App\Repositories\Supplier\Sort\SortByDisplayOrder;
use App\Repositories\Supplier\Sort\SortByInChargePerson;
use App\Repositories\Supplier\Sort\SortByPhone;
use App\Repositories\Supplier\Sort\SortBySiteName;
use App\Repositories\Supplier\Sort\SortBySupplierPerson;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class SupplierRepository extends BaseRepository implements ISupplierRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return Supplier::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('supplier_classification'),
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
        'code',
        'id',
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('company_name', new SortByCompanyName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('site_name', new SortBySiteName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('site_address', new SortByAddress())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('site_phone', new SortByPhone())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('company_person', new SortByInChargePerson())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('supplier_person', new SortBySupplierPerson())->defaultDirection(SortDirection::ASCENDING),
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
            ->defaultSort($this->defaultSort)
            ->addSelect(Supplier::$selectProps);
    }

    public function getDetail(Supplier $detail): Supplier
    {
        return $detail->load(['salesStore.company', 'supplierPerson', 'myCompanyPerson', 'createdBy', 'updatedBy',]);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->with(['salesStore.company', 'supplierPerson', 'myCompanyPerson'])->paginate($this->getPerPage());
    }

    public function numberOfRecords(): int
    {
        return QueryBuilder::for($this->model())->count();
    }

    public function getSocialEventSuppliers(SocialEvent $socialEvent): Collection
    {
        $productIds = SocialData::whereHas('workflows', function (Builder $query) {
            $query->where([
                'workflow_order' => WorkflowOrderEnum::ORDER,
                'execution_type' => ExecutionOrderEnum::ORDERED
            ]);
        })->where('social_social_datas.social_event_id', $socialEvent->id)->select('product_id');

        return Supplier::whereHas('products', function (Builder $query) use ($productIds) {
            $query->whereIn('id', $productIds);
        })->leftJoin('organization_sites', 'social_suppliers.sales_store_id', '=', 'organization_sites.id')
            ->with(['salesStore.company'])->orderBy('organization_sites.display_order')->select(Supplier::$selectProps)->get();
    }

    public function getSocialEventSupplierDetail(): Supplier|null
    {
        $filter = request('filter');
        $supplierId = $filter && !empty($filter['supplier_id']) ? $filter['supplier_id'] : null;
        return Supplier::where('id', $supplierId)->with(['salesStore.company'])->select(Supplier::$selectProps)->first();
    }

    public function getFiveYearTotalOfSupplier(Supplier $supplier): Supplier|null
    {
        $currentYear = Carbon::now()->year;
        return $supplier->load(['products' => function (HasMany $productQuery) use ($currentYear) {
            $productQuery->with(['socialData' => function (HasMany $socialDataQuery) use ($currentYear) {
                $socialDataQuery->whereHas('workflows', function (Builder $workflowQuery) use ($currentYear) {
                    $workflowQuery->where([
                        'workflow_order' => WorkflowOrderEnum::PAYMENT,
                        'execution_type' => ExecutionPaymentEnum::PAID
                    ])->where(function (Builder $subQuery) use ($currentYear) {
                        $subQuery->whereYear('execution_at', '<=', $currentYear)
                            ->whereYear('execution_at', '>=', $currentYear - 4);
                    });
                })->with(['workflows']);
            }]);
        }]);
    }

    public function checkRelations(Supplier $supplier): Supplier|Model
    {
        return QueryBuilder::for($this->model())
            ->withCount('products')
            ->find($supplier->id);
    }
}
