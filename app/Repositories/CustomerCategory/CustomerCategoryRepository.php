<?php

namespace App\Repositories\CustomerCategory;

use App\Models\CustomerCategory;
use App\Models\ManagementGroup;
use App\Query\CustomerCategory\CustomerCategoryDropdownQuery;
use App\Query\ManagementGroup\ManagementGroupDropdownQuery;
use App\Trait\HasPagination;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;

class CustomerCategoryRepository extends BaseRepository implements ICustomerCategoryRepository
{
    use HasPagination;

    public function model(): string
    {
        return CustomerCategory::class;
    }

    protected string $defaultSort = 'name';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
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
        'name',
        'id',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
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

    public function findByQuery(CustomerCategoryDropdownQuery $query): Collection|array
    {
        return $query->select(CustomerCategory::$selectProps)->orderBy($this->defaultSort)->get()
            ->unique('name');
    }
}
