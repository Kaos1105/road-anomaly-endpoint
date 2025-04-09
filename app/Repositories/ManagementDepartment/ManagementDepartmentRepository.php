<?php

namespace App\Repositories\ManagementDepartment;

use App\Enums\Common\UseFlagEnum;
use App\Models\ManagementDepartment;
use App\Repositories\ManagementDepartment\Filter\FilterByName;
use App\Repositories\ManagementDepartment\Sort\SortByDepartment;
use App\Repositories\ManagementDepartment\Sort\SortByDisplayOrder;
use App\Repositories\ManagementDepartment\Sort\SortByManagementDepartment;
use App\Repositories\ManagementDepartment\Sort\SortByNumberOfUsers;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ManagementDepartmentRepository extends BaseRepository implements IManagementDepartmentRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return ManagementDepartment::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('department_id'),
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
            AllowedFilter::custom('search', new FilterByName())
        ];
    }

    protected array $allowedSorts = [
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('management_department', new SortByManagementDepartment()),
            AllowedSort::custom('department', new SortByDepartment()),
            AllowedSort::custom('number_of_users', new SortByNumberOfUsers()),
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
            ->defaultSort(AllowedSort::custom('display_order', new SortByDisplayOrder()))
            ->select(ManagementDepartment::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->withCount(['myCompanyEmployees' => function (Builder $query) {
                $query->where('use_classification', UseFlagEnum::USE);
            }])
            ->with('department')
            ->join('organization_departments', 'negotiation_management_departments.department_id', '=', 'organization_departments.id')
            ->addSelect(['department_code' => self::getCountFavoriteQuery($this->model())])
            ->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function findAllByEmployeeId(int $employeeId): Collection|array
    {
        return QueryBuilder::for(ManagementDepartment::class)
            ->whereHas('myCompanyEmployees', function (Builder $query) use ($employeeId) {
                $query->where('employee_id', $employeeId);
            })
            ->where('use_classification', UseFlagEnum::USE)
            ->orderBy('display_order')
            ->get();
    }

    public function numberOfRecordByEmployeeId(int $employeeId): int
    {
        return QueryBuilder::for(ManagementDepartment::class)
            ->whereHas('myCompanyEmployees', function (Builder $query) use ($employeeId) {
                $query->where('employee_id', $employeeId);
            })
            ->count();
    }


    public function getDetail(ManagementDepartment $managementDepartment): Model|QueryBuilder
    {
        return $managementDepartment->load(['department']);
    }

    public function checkRelations(ManagementDepartment $managementDepartment): Model|ManagementDepartment
    {
        return QueryBuilder::for($this->model())
            ->withCount('myCompanyEmployees')
            ->find($managementDepartment->id);
    }

}
