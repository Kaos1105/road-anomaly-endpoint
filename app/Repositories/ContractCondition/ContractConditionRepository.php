<?php

namespace App\Repositories\ContractCondition;

use App\Models\ContractCondition;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContractConditionRepository extends BaseRepository implements IContractConditionRepository
{
    use HasPagination;

    public function model(): string
    {
        return ContractCondition::class;
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
        return [];
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
            ->select(ContractCondition::$selectProps);

    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }


    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(ContractCondition::$selectProps)->orderBy('display_order')->get();
    }

    public function showDetail(ContractCondition $contractCondition): Model|QueryBuilder
    {
        return $contractCondition->load(['createdBy', 'updatedBy']);
    }


    public function checkRelations(ContractCondition $contractCondition): Model|ContractCondition
    {
        return QueryBuilder::for($this->model())
            ->find($contractCondition->id);
    }

}
