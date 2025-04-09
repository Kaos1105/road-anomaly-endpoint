<?php

namespace App\Repositories\BasicContract;

use App\Models\BasicContract;
use App\Repositories\BasicContract\Filter\FilterByCodeName;
use App\Repositories\BasicContract\Filter\FilterByContractStatus;
use App\Repositories\BasicContract\Sort\SortByApprovalFlag;
use App\Repositories\BasicContract\Sort\SortByCode;
use App\Repositories\BasicContract\Sort\SortByCounterparty;
use App\Repositories\BasicContract\Sort\SortByCounterpartyRepresentative;
use App\Repositories\BasicContract\Sort\SortByDisplayOrder;
use App\Repositories\BasicContract\Sort\SortByNo;
use App\Repositories\BasicContract\Sort\SortByOurCompany;
use App\Repositories\BasicContract\Sort\SortByOurCompanyRepresentative;
use App\Repositories\BasicContract\Sort\SortBySigningAt;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class BasicContractRepository extends BaseRepository implements IBasicContractRepository
{
    use HasPagination;

    public function model(): string
    {
        return BasicContract::class;
    }

    protected array $allowedFilters = [];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('counterparty_id'),
            AllowedFilter::exact('site_id'),
            AllowedFilter::exact('approval_flag'),
            AllowedFilter::custom('search', new FilterByCodeName()),
            AllowedFilter::custom('contract_status', new FilterByContractStatus()),
        ];
    }

    protected function allowedScopedFilters(): array
    {
        return [];
    }

    protected function allowedCustomFilters(): array
    {
        return [];
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedSorts = [
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('no', new SortByNo()),
            AllowedSort::custom('code', new SortByCode()),
            AllowedSort::custom('signing_at', new SortBySigningAt()),
            AllowedSort::custom('approval_flag', new SortByApprovalFlag()),
            AllowedSort::custom('display_order', new SortByDisplayOrder()),
            AllowedSort::custom('counterparty', new SortByCounterparty()),
            AllowedSort::custom('counterparty_representative', new SortByCounterpartyRepresentative()),
            AllowedSort::custom('our_company', new SortByOurCompany()),
            AllowedSort::custom('our_company_representative', new SortByOurCompanyRepresentative()),
        ];
    }

    protected array $allowedIncludes = [];

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
            ->select(BasicContract::$selectProps);

    }

    private function addSelectDisplayOrder(BuilderQuery $query, string $table, string $foreignColumn): Builder
    {
        return $query->select("{$table}.display_order")
            ->from($table)
            ->whereColumn("{$table}.id", "=", "contract_basic_contracts.{$foreignColumn}");
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model())
            ->select(BasicContract::$selectProps)
            ->addSelect([
                'counterparty_display_order' => function (BuilderQuery $query) {
                    $this->addSelectDisplayOrder($query, 'organization_sites', 'counterparty_id');
                },
                'counterparty_representative_display_order' => function (BuilderQuery $query) {
                    $this->addSelectDisplayOrder($query, 'organization_employees', 'counterparty_representative_id');
                },
                'our_company_display_order' => function (BuilderQuery $query) {
                    $this->addSelectDisplayOrder($query, 'organization_sites', 'site_id');
                },
                'our_company_representative_display_order' => function (BuilderQuery $query) {
                    $this->addSelectDisplayOrder($query, 'organization_employees', 'representative_id');
                }
            ])
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
            ->with(['counterparty.company', 'counterpartyContractor', 'counterpartyRepresentative', 'site.company', 'contractor', 'representative'])
            ->defaultSort(AllowedSort::custom('display_order', new SortByDisplayOrder()))
            ->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }


    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(BasicContract::$selectProps)->orderBy('display_order')->get();
    }

    public function showDetail(BasicContract $basicContract): Model|QueryBuilder
    {
        return $basicContract->load([
            'counterparty.company',
            'counterpartyContractor',
            'counterpartyRepresentative',
            'site.company',
            'contractor',
            'representative',
            'createdBy',
            'updatedBy'
        ]);
    }

    public function checkRelations(BasicContract $basicContract): Model|BasicContract
    {
        return QueryBuilder::for($this->model())
            ->withCount('contractWorkplaces')
            ->withCount('individualContracts')
            ->find($basicContract->id);
    }

}
