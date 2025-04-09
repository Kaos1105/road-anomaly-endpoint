<?php

namespace App\Repositories\Division;

use App\Enums\Common\RepresentFlagEnum;
use App\Models\Department;
use App\Models\Division;
use App\Query\Division\DivisionDropdownQuery;
use App\Repositories\Division\Sort\SortByDisplayOrder;
use App\Repositories\Division\Sort\SortByDivisionClassification;
use App\Repositories\Division\Sort\SortByDivisionCode;
use App\Repositories\Division\Sort\SortByDivisionName;
use App\Repositories\Division\Sort\SortByFavorite;
use App\Repositories\Division\Sort\SortByPhone;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class DivisionRepository extends BaseRepository implements IDivisionRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return Division::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('department_id'),
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
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('code', new SortByDivisionCode())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('name', new SortByDivisionName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('phone', new SortByPhone())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('division_classification', new SortByDivisionClassification())->defaultDirection(SortDirection::ASCENDING),
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
            ->defaultSort(AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING))
            ->select(Division::$selectProps)
            ->addSelect(['count_favorites' => self::getCountFavoriteQuery($this->model())]);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function showDetail(Division $division): Model|QueryBuilder
    {
        return $division->load(['department', 'employeeFavorites', 'createdBy', 'updatedBy',]);
    }

    public function getListDivisionsByDepartment(Department $department): Collection|array
    {
        return $this->filters()
            ->where('department_id', $department->id)
            ->get();
    }

    /**
     * @throws ValidatorException
     */
    public function setRepresentativeDivision(Department $department, int $representDivisionId, array $dataUpdate): void
    {
        $previousRepresentative = Division::where([
            'department_id' => $department->id,
            'represent_flg' => RepresentFlagEnum::REPRESENTATIVE
        ])->first();

        if ($previousRepresentative) {
            $this->update([...$dataUpdate, 'represent_flg' => RepresentFlagEnum::NOT_SPECIFIED], $previousRepresentative->id);
        }
        $this->update([...$dataUpdate, 'represent_flg' => RepresentFlagEnum::REPRESENTATIVE], $representDivisionId);
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(Division::$selectProps)->orderBy($this->defaultSort)->get();
    }

    public function checkRelations(Division $division): Model|Division
    {
        return QueryBuilder::for($this->model())
            ->withCount('employees')
            ->withCount('contractWorkplaces')
            ->find($division->id);
    }
}
