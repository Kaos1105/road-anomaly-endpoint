<?php

namespace App\Repositories\Product;

use App\Enums\Common\UseFlagEnum;
use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\Company;
use App\Models\Product;
use App\Models\SocialData;
use App\Models\Supplier;
use App\Query\Product\SocialDataProductQuery;
use App\Repositories\Product\Filter\FilterByCompanyId;
use App\Repositories\Product\Filter\FilterByProductName;
use App\Repositories\Product\Sort\SortByCode;
use App\Repositories\Product\Sort\SortByDisplayOrder;
use App\Repositories\Product\Sort\SortByName;
use App\Repositories\Product\Sort\SortByStoreName;
use App\Repositories\Product\Sort\SortBySupplierName;
use App\Repositories\Product\Sort\SortByUnitPrice;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository extends BaseRepository implements IProductRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return Product::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('product_classification'),
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
            AllowedFilter::custom('name', new  FilterByProductName()),
            AllowedFilter::custom('company_id', new  FilterByCompanyId())
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
            AllowedSort::custom('code', new SortByCode())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('name', new SortByName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('unit_price', new SortByUnitPrice())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('store_name', new SortByStoreName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('supplier_name', new SortBySupplierName())->defaultDirection(SortDirection::ASCENDING),
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
            ->defaultSort(AllowedSort::custom('code', new SortByCode())->defaultDirection(SortDirection::ASCENDING))
            ->addSelect(Product::$selectProps);
    }

    public function getDetail(Product $detail): Product
    {
        return $detail->load(['supplier', 'site.company', 'createdBy', 'updatedBy']);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->with(['supplier', 'site.company'])->paginate($this->getPerPage());
    }

    /**
     * @throws ValidatorException
     */
    public function createProduct(array $dataInsert): Product
    {
        $result = $this->create($dataInsert);
        return $this->getDetail($result);
    }

    /**
     * @throws ValidatorException
     */
    public function updateProduct(array $dataUpdate, Product $customer): Product
    {
        $result = $this->update($dataUpdate, $customer->id);
        return $this->getDetail($result);
    }

    public function allSuppliersByProducts(): Collection
    {
        return QueryBuilder::for($this->model())->join('social_suppliers', 'social_products.supplier_id', '=', 'social_suppliers.id')
            ->join('organization_sites', 'social_suppliers.sales_store_id', '=', 'organization_sites.id')
            ->join('organization_companies', 'organization_sites.company_id', '=', 'organization_companies.id')
            ->select(Company::$selectProps)->distinct()
            ->orderBy('organization_companies.display_order')->get();
    }

    public function getSocialDataProductDropdown(SocialDataProductQuery $query): Collection
    {
        return $query->with(['site.company'])
            ->setFilterParam([
                'use_classification' => UseFlagEnum::USE
            ])
            ->select(Product::$selectProps)->orderBy($this->defaultSort)->get();
    }


    public function allProductsBySupplier(Supplier $supplier): Collection
    {
        return QueryBuilder::for($this->model())
            ->where('supplier_id', $supplier->id)
            ->defaultSort($this->defaultSort)
            ->select(Product::$selectProps)->get();
    }

    public function numberOfRecords(): int
    {
        return QueryBuilder::for($this->model())->count();
    }

    public function mostBoughtProductPastThreeYears(Supplier $supplier, Collection $socialData): Collection
    {
        $socialDataIds = $socialData->pluck('id')->toArray();
        $sortedProductIds = $socialData->pluck('product_id')->unique()->toArray();

        return QueryBuilder::for($this->model())
            ->whereIn('id', $sortedProductIds)
            ->where('supplier_id', $supplier->id)
            ->select(Product::$selectProps)
            ->limit(5)
            ->addSelect(
                [
                    'social_data_count' => SocialData::selectRaw('COUNT(*)')
                        ->whereColumn('social_social_datas.product_id', 'social_products.id') // Link product_id
                        ->whereIn('id', $socialDataIds) // Match only socialData in the collection
                ])
            ->orderByDesc('social_data_count')->get();
    }


    public function getFiveYearTotalOfProduct(Product $detail): Product
    {
        $currentYear = Carbon::now()->year;

        return $detail->load([
            'socialData' => function (HasMany $socialDataQuery) use ($currentYear) {
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
    }


    public function checkRelations(Product $product): Product|Model
    {
        return QueryBuilder::for($this->model())
            ->withCount('socialData')
            ->find($product->id);
    }
}
