<?php

namespace App\Repositories\ContractUserSetting;

use App\Models\ContractUserSetting;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContractUserSettingRepository extends BaseRepository implements IContractUserSettingRepository
{
    use HasPagination;

    public function model(): string
    {
        return ContractUserSetting::class;
    }

    protected array $allowedFilters = [];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
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

    protected string $defaultSort = 'updated_at';

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
            ->select(ContractUserSetting::$selectProps);

    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function showDetail(ContractUserSetting $contractUserSetting): Model|QueryBuilder
    {
        return $contractUserSetting->load(['createdBy', 'updatedBy']);
    }


}
