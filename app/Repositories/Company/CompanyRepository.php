<?php

namespace App\Repositories\Company;

use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Enums\Contract\CompanyEnum;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Site;
use App\Query\Company\CompanyDropdownQuery;
use App\Repositories\Company\Filter\FilterByCompanyGroupName;
use App\Repositories\Company\Filter\FilterByCompanyName;
use App\Repositories\Company\Sort\SortByCompanyClassification;
use App\Repositories\Company\Sort\SortByCompanyCode;
use App\Repositories\Company\Sort\SortByCompanyName;
use App\Repositories\Company\Sort\SortByDisplayOrder;
use App\Repositories\Company\Sort\SortByFavorite;
use App\Repositories\Company\Sort\SortBySiteAddress;
use App\Repositories\Company\Sort\SortBySiteName;
use App\Repositories\Company\Sort\SortBySitePhone;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
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

class CompanyRepository extends BaseRepository implements ICompanyRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return Company::class;
    }

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('company_classification'),
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
            AllowedFilter::custom('group_name', new FilterByCompanyGroupName()),
            AllowedFilter::custom('name', new FilterByCompanyName()),
        ];
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedSorts = [
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('code', new SortByCompanyCode())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('name', new SortByCompanyName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('site', new SortBySiteName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('address', new SortBySiteAddress())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('phone', new SortBySitePhone())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('company_classification', new SortByCompanyClassification())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING),
        ];
    }

    protected array $allowedIncludes = [
        'sites',
    ];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
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
            ->with(['sites' => function (HasMany $query) {
                $query->where('represent_flg', '=', RepresentFlagEnum::REPRESENTATIVE)
                    ->where('use_classification', '=', UseFlagEnum::USE)
                    ->orderBy('display_order')
                    ->limit(1);
            }])
            ->defaultSort(AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING))
            ->select(Company::$selectProps)
            //TODO: refactor left join
            ->addSelect([
                'site_long_name' => self::siteRepresentativeQuery('long_name'),
                'site_phone' => self::siteRepresentativeQuery('phone'),
                'site_address_1' => self::siteRepresentativeQuery('address_1'),
                'site_address_2' => self::siteRepresentativeQuery('address_2'),
                'site_address_3' => self::siteRepresentativeQuery('address_3'),
                'count_favorites' => self::getCountFavoriteQuery($this->model())
            ]);
    }

    private function siteRepresentativeQuery(string $selectColumn): Builder
    {
        return Site::query()->select($selectColumn)
            ->whereColumn('company_id', '=', 'organization_companies.id')
            ->where('represent_flg', '=', RepresentFlagEnum::REPRESENTATIVE)
            ->where('use_classification', '=', UseFlagEnum::USE)
            ->orderBy('display_order')
            ->limit(1);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function getGroupCompanyList(): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->select('group_name')->distinct()
            ->whereNotNull('group_name')
            ->orderBy($this->defaultSort)
            ->get();
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(Company::$selectProps)->orderBy('display_order')->get();
    }

    public function showDetail(Company $company): Model|QueryBuilder
    {
        return $company->load(['employeeFavorites', 'createdBy', 'updatedBy']);
    }

    public static function checkExistShinichiro(): Model|Company|null
    {
        return Company::where('company_classification', CompanyClassificationEnum::SHINNICHIRO)
            ->first();
    }

    public function getCompanySupplier(CompanyDropdownQuery $query): Collection|array
    {
        return $query->select(Company::$selectProps)
            ->whereIn('company_classification', [
                CompanyClassificationEnum::CUSTOMER,
                CompanyClassificationEnum::SHINNICHIRO,
                CompanyClassificationEnum::FAVORITE_CUSTOMER,
                CompanyClassificationEnum::SUPPLIER,
            ])
            ->whereHas('sites')->orderBy('display_order')->get();
    }

    public function checkRelations(Company $company): Model|Company
    {
        return QueryBuilder::for($this->model())
            ->withCount('sites')
            ->withCount('employees')
            ->find($company->id);
    }

    public function dropdownCustomerCompany(): Collection
    {
        $transferIds = Customer::query()
            ->leftJoin('organization_transfers', 'social_customers.display_transfer_id', '=', 'organization_transfers.id')
            ->select('organization_transfers.company_id');
        return Company::query()->whereIn('id', $transferIds)->orderBy('display_order')->get();
    }

    public function getCompanyContractDropdown(bool $isCounterparty = true): Collection
    {
        $query = QueryBuilder::for($this->model())
            ->select(Company::$selectProps)
            ->where('use_classification', UseFlagEnum::USE);
        if (!$isCounterparty) {
            $query = $query->where('group_name', CompanyEnum::OUR_COMPANY_GROUP);
        }
        return $query->orderBy('display_order')->get();
    }
}
