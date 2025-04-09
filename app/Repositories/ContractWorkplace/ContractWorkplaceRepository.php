<?php

namespace App\Repositories\ContractWorkplace;

use App\Models\BasicContract;
use App\Models\ContractWorkplace;
use App\Repositories\ContractWorkplace\Sort\SortByDisplayOrder;
use App\Repositories\ContractWorkplace\Sort\SortByMemo;
use App\Repositories\ContractWorkplace\Sort\SortByWorkplaceName;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ContractWorkplaceRepository extends BaseRepository implements IContractWorkplaceRepository
{
    use HasPagination;

    public function model(): string
    {
        return ContractWorkplace::class;
    }

    protected array $allowedFilters = [];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('use_classification'),
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
            AllowedSort::custom('workplace_name', new SortByWorkplaceName()),
            AllowedSort::custom('note', new SortByMemo()),
            AllowedSort::custom('display_order', new SortByDisplayOrder()),
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
            ->select(ContractWorkplace::$selectProps);

    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(BasicContract $basicContract): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->where('basic_contract_id', $basicContract->id)
            ->allowedSorts([
                ...$this->allowedSorts,
                ...$this->allowedCustomSorts(),
            ])
            ->defaultSort(AllowedSort::custom('display_order', new SortByDisplayOrder()))
            ->select(ContractWorkplace::$selectProps)
            ->addSelect(['workplace_name' => function (Builder $query) {
                $query->selectRaw('organization_divisions.long_name')
                    ->from('organization_divisions')
                    ->whereColumn('organization_divisions.id', '=', 'contract_contract_workplaces.division_id');
            }])
            ->with(['division', 'createdBy', 'updatedBy'])
            ->get();
    }


    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(ContractWorkplace::$selectProps)->orderBy('display_order')->get();
    }

    public function showDetail(ContractWorkplace $contractWorkplace): Model|QueryBuilder
    {
        return $contractWorkplace->load(['createdBy', 'updatedBy']);
    }


}
