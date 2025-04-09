<?php

namespace App\Repositories\MyCompanyEmployee;

use App\Enums\Company\CompanyClassificationEnum;
use App\Models\ManagementDepartment;
use App\Models\MyCompanyEmployee;
use App\Repositories\AccessPermission\AccessPermissionRepository;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MyCompanyEmployeeRepository extends BaseRepository implements IMyCompanyEmployeeRepository
{
    use HasPagination;

    public function model(): string
    {
        return MyCompanyEmployee::class;
    }

    protected string $defaultSort = 'display_order';

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
        'code',
        'id',
        'updated_at'
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
            ->select(MyCompanyEmployee::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->paginate($this->getPerPage());
    }

    public function findAll(ManagementDepartment $managementDepartment): Collection|array
    {
        return QueryBuilder::for(MyCompanyEmployee::class)
            ->whereHas('managementDepartments', function (Builder $query) use ($managementDepartment) {
                $query->where('negotiation_management_departments.id', $managementDepartment->id);
            })
            ->with('employee', function (BelongsTo $employeeQuery) {
                $employeeQuery->with('transfers', function (HasMany $transferQuery) {
                    $now = Carbon::now();
                    AccessPermissionRepository::filterTransferByDateConditions($transferQuery->getQuery(), $now);
                    $transferQuery->with(['site', 'department', 'division'])->orderBy('start_date');
                });
            })
            ->orderBy($this->defaultSort)
            ->get();
    }

    public function showDetail(MyCompanyEmployee $myCompanyEmployee): Model|QueryBuilder
    {
        return $myCompanyEmployee;
    }


    public function checkRelations(MyCompanyEmployee $myCompanyEmployee): Model|MyCompanyEmployee|null
    {
        return QueryBuilder::for($this->model())
            ->withCount('negotiable')
            ->find($myCompanyEmployee->id);
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(MyCompanyEmployee::$selectProps)
            ->with('employee')
            ->orderBy('display_order')
            ->get();
    }

}
