<?php

namespace App\Repositories\ClientSite;

use App\Enums\Common\UseFlagEnum;
use App\Models\ClientSite;
use App\Repositories\ClientSite\Filter\FilterByManagementDepartmentId;
use App\Repositories\ClientSite\Filter\FilterByName;
use App\Repositories\ClientSite\Sort\SortByCompanyName;
use App\Repositories\ClientSite\Sort\SortByDisplayOrder;
use App\Repositories\ClientSite\Sort\SortBySiteName;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ClientSiteRepository extends BaseRepository implements IClientSiteRepository
{
    use HasPagination;

    public function model(): string
    {
        return ClientSite::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
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
            AllowedFilter::custom('search', new FilterByName()),
            AllowedFilter::custom('management_department_id', new FilterByManagementDepartmentId())
        ];
    }

    protected array $allowedSorts = [
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('company_name', new SortByCompanyName()),
            AllowedSort::custom('site_name', new SortBySiteName()),
            AllowedSort::custom('display_order', new SortByDisplayOrder()),
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
            ->select(ClientSite::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->with(['site.company'])
            ->join('organization_sites', 'organization_sites.id', '=', 'negotiation_client_sites.site_id')
            ->join('organization_companies', 'organization_sites.company_id', '=', 'organization_companies.id')
            ->withCount([
                'negotiations',
                'clientEmployees' => function (Builder $query) {
                    $query->where('use_classification', UseFlagEnum::USE);
                }
            ])
            ->selectRaw('CASE WHEN organization_sites.short_name IS NOT NULL THEN organization_sites.short_name ELSE organization_sites.long_name END as site_name')
            ->selectRaw('CASE WHEN organization_companies.short_name IS NOT NULL THEN organization_companies.short_name ELSE organization_companies.long_name END AS company_name')
            ->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }


    public function getDetail(ClientSite $clientSite): Model|QueryBuilder
    {
        return $clientSite->load('site.company');
    }


    public function checkRelations(ClientSite $clientSite): Model|ClientSite
    {
        return QueryBuilder::for($this->model())
            ->withCount('clientEmployees')
            ->withCount('negotiations')
            ->find($clientSite->id);
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(ClientSite::$selectProps)
            ->with('site.company')
            ->orderBy('display_order')
            ->get();
    }

    public static function getClientSitesByManagementDepartment(int $managementDepartmentId): \Illuminate\Support\Collection
    {
        return QueryBuilder::for(ClientSite::class)->select('id')
            ->where('management_department_id', $managementDepartmentId)
            ->get()->pluck('id');
    }

    public static function countClientSitesByManagementDepartments(array $managementDepartmentIds): int
    {
        return QueryBuilder::for(ClientSite::class)
            ->whereIn('management_department_id', $managementDepartmentIds)
            ->count();
    }
}
