<?php

namespace App\Repositories\IndividualContract;

use App\Models\BasicContract;
use App\Models\IndividualContract;
use App\Repositories\IndividualContract\Sort\SortByDisplayOrder;
use App\Repositories\IndividualContract\Sort\SortByEndDate;
use App\Repositories\IndividualContract\Sort\SortByName;
use App\Repositories\IndividualContract\Sort\SortByRoundingMethod;
use App\Repositories\IndividualContract\Sort\SortByStartDate;
use App\Repositories\IndividualContract\Sort\SortByUnitClassification;
use App\Repositories\IndividualContract\Sort\SortByUnitName;
use App\Repositories\IndividualContract\Sort\SortByUnitPrice;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class IndividualContractRepository extends BaseRepository implements IIndividualContractRepository
{
    use HasPagination;

    public function model(): string
    {
        return IndividualContract::class;
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

    protected array $allowedSorts = ['updated_at'];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('name', new SortByName()),
            AllowedSort::custom('start_date', new SortByStartDate()),
            AllowedSort::custom('end_date', new SortByEndDate()),
            AllowedSort::custom('unit_price', new SortByUnitPrice()),
            AllowedSort::custom('unit_classification', new SortByUnitClassification()),
            AllowedSort::custom('unit_name', new SortByUnitName()),
            AllowedSort::custom('rounding_method', new SortByRoundingMethod()),
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
            ->select(IndividualContract::$selectProps);

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
            ->select(IndividualContract::$selectProps)
            ->with(['createdBy', 'updatedBy'])
            ->get();
    }


    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(IndividualContract::$selectProps)->orderBy('display_order')->get();
    }

    public function showDetail(IndividualContract $individualContract): Model|QueryBuilder
    {
        return $individualContract->load(['createdBy', 'updatedBy', 'basicContract', 'basicContract.createdBy',
            'basicContract.updatedBy']);
    }
}
