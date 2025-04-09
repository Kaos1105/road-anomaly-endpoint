<?php

namespace App\Repositories\Site;

use App\Enums\Common\RepresentFlagEnum;
use App\Models\Company;
use App\Models\Site;
use App\Query\Site\SiteDropdownQuery;
use App\Repositories\Site\Filter\FilterBySiteName;
use App\Repositories\Site\Sort\Company\SortBySiteAddress;
use App\Repositories\Site\Sort\Company\SortBySiteClassification;
use App\Repositories\Site\Sort\Company\SortBySiteCode;
use App\Repositories\Site\Sort\Company\SortBySiteDisplayOrder;
use App\Repositories\Site\Sort\Company\SortBySiteFavorite;
use App\Repositories\Site\Sort\Company\SortBySiteName;
use App\Repositories\Site\Sort\Company\SortBySitePhone;
use App\Repositories\Site\Sort\SortByAddress;
use App\Repositories\Site\Sort\SortByCode;
use App\Repositories\Site\Sort\SortByCompanyName;
use App\Repositories\Site\Sort\SortByDisplayOrder;
use App\Repositories\Site\Sort\SortByFavorite;
use App\Repositories\Site\Sort\SortByName;
use App\Repositories\Site\Sort\SortByUseClassification;
use App\Trait\ActivePeriodQuery;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class SiteRepository extends BaseRepository implements ISiteRepository
{
    use HasPagination, HasFavorite, ActivePeriodQuery;

    public function model(): string
    {
        return Site::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('company_id'),
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('site_classification'),
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
            AllowedFilter::custom('name', new FilterBySiteName())
        ];
    }

    protected array $allowedSorts = [
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('code', new SortByCode())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('name', new SortByName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('address', new SortByAddress())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('company_name', new SortByCompanyName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('use_classification', new SortByUseClassification())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING),
        ];
    }

    protected array $allowedIncludes = [
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
            ->defaultSort($this->defaultSort)
            ->select(Site::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->with('company')
            ->leftJoin('organization_companies', 'organization_sites.company_id', '=', 'organization_companies.id')
            ->addSelect(['count_favorites' => self::getCountFavoriteQuery($this->model())])
            ->defaultSort(AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING))
            ->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function getListSitesByCompany(int $companyId): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->where('organization_sites.company_id', $companyId)
//            ->where('organization_sites.use_classification', UseFlagEnum::USE)
            ->allowedSorts([
                ...$this->allowedSorts,
                AllowedSort::custom('code', new SortBySiteCode())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('name', new SortBySiteName())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('address', new SortBySiteAddress())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('phone', new SortBySitePhone())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('display_order', new SortBySiteDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('site_classification', new SortBySiteClassification())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('favorite', new SortBySiteFavorite())->defaultDirection(SortDirection::ASCENDING),
            ])
            ->defaultSort(AllowedSort::custom('favorite', new SortBySiteFavorite())->defaultDirection(SortDirection::DESCENDING))
            ->select(Site::$selectProps)
            ->addSelect(['count_favorites' => self::getCountFavoriteQuery($this->model())])
            ->get();
    }


    public function getDetail(Site $site): Model|QueryBuilder
    {
        return $site->load(['company', 'employeeFavorites', 'createdBy', 'updatedBy',]);
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(Site::$selectProps)->orderBy('display_order')->get();
    }

    /**
     * @throws ValidatorException
     */
    public function setRepresentativeSite(Company $company, int $representSiteId, array $dataUpdate): void
    {
        $previousRepresentative = Site::where([
            'company_id' => $company->id,
            'represent_flg' => RepresentFlagEnum::REPRESENTATIVE
        ])->first();

        if ($previousRepresentative) {
            $this->update([...$dataUpdate, 'represent_flg' => RepresentFlagEnum::NOT_SPECIFIED], $previousRepresentative->id);
        }
        $this->update([...$dataUpdate, 'represent_flg' => RepresentFlagEnum::REPRESENTATIVE], $representSiteId);
    }

    public function getSiteStores(SiteDropdownQuery $query): Collection|array
    {
        return $query->whereNotExists(fn(Builder $query) => $query->select()->from('social_suppliers')
            ->whereColumn('social_suppliers.sales_store_id', '=', 'organization_sites.id'))
            ->select(Site::$selectProps)->orderBy('display_order')->get();
    }

    public function checkRelations(Site $site): Model|Site
    {
        return QueryBuilder::for($this->model())
            ->withCount('departments')
            ->withCount('employees')
            ->withCount('suppliers')
            ->with('clientSite')
            ->withCount('ourSiteContract')
            ->withCount('counterparty')
            ->find($site->id);
    }

    public function getSiteContractDropdown(bool $isCounterparty = true): Collection
    {
        $query = QueryBuilder::for($this->model())
            ->distinct('organization_sites.id')
            ->select(Site::$selectProps)
            ->join('organization_companies', 'organization_sites.company_id', '=', 'organization_companies.id');
        if ($isCounterparty) {
            $query->join('contract_basic_contracts', 'organization_sites.id', '=', 'contract_basic_contracts.counterparty_id');
        } else {
            $query->join('contract_basic_contracts', 'organization_sites.id', '=', 'contract_basic_contracts.site_id');
        }
        return $query->with('company')
            ->orderBy('organization_companies.display_order')
            ->orderBy('organization_sites.display_order')
            ->get();
    }
}
