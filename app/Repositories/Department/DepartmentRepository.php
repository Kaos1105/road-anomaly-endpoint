<?php

namespace App\Repositories\Department;

use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Enums\Transfer\MajorHistoryEnum;
use App\Models\Department;
use App\Models\Site;
use App\Repositories\Department\Sort\Site\SortByDepartmentClassification;
use App\Repositories\Department\Sort\Site\SortByDepartmentCode;
use App\Repositories\Department\Sort\Site\SortByDepartmentName;
use App\Repositories\Department\Sort\Site\SortByDisplayOrder;
use App\Repositories\Department\Sort\Site\SortByFavorite;
use App\Repositories\Department\Sort\Site\SortByPhone;
use App\Repositories\Department\Sort\Site\SortByUseClassification;
use App\Repositories\Employee\EmployeeRepository;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class DepartmentRepository extends BaseRepository implements IDepartmentRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return Department::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('site_id'),
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
        ];
    }

    protected array $allowedSorts = [
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
            ->select(Department::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function getListDepartmentsBySite(int $siteId): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->where('site_id', $siteId)
            ->allowedSorts([
                ...$this->allowedSorts,
                AllowedSort::custom('code', new SortByDepartmentCode())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('name', new SortByDepartmentName())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('phone', new SortByPhone())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('use_classification', new SortByUseClassification())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('department_classification', new SortByDepartmentClassification())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING),
            ])
            ->defaultSort(AllowedSort::custom('favorite', new SortByFavorite())->defaultDirection(SortDirection::DESCENDING))
            ->select(Department::$selectProps)
            ->addSelect(['count_favorites' => self::getCountFavoriteQuery($this->model())])
            ->get();
    }

    public function getDetail(Department $department): Model|QueryBuilder
    {
        return $department->load(['site', 'company', 'createdBy', 'updatedBy',]);
    }

    /**
     * @throws ValidatorException
     */
    public function setRepresentativeDepartment(Site $site, int $representDepartmentId, array $dataUpdate): void
    {
        $previousRepresentative = Department::where([
            'site_id' => $site->id,
            'represent_flg' => RepresentFlagEnum::REPRESENTATIVE
        ])->first();

        if ($previousRepresentative) {
            $this->update([...$dataUpdate, 'represent_flg' => RepresentFlagEnum::NOT_SPECIFIED], $previousRepresentative->id);
        }
        $this->update([...$dataUpdate, 'represent_flg' => RepresentFlagEnum::REPRESENTATIVE], $representDepartmentId);
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(Department::$selectProps)->orderBy($this->defaultSort)->get();
    }


    public function getShinichiroDepartments(): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->where('organization_departments.use_classification', UseFlagEnum::USE)
            ->whereHas('company', function (EloquentBuilder $query) {
                $query->where('organization_companies.company_classification', CompanyClassificationEnum::SHINNICHIRO)
                    ->where('organization_companies.use_classification', UseFlagEnum::USE);
            })
            ->whereHas('site', function (EloquentBuilder $query) {
                $query->where('organization_sites.use_classification', UseFlagEnum::USE);
            })
            ->select(Department::$selectProps)
            ->addSelect(['number_of_employees' => function (Builder $query) {
                $query->selectRaw('count(distinct organization_transfers.employee_id)')
                    ->from('organization_transfers')
                    ->whereColumn('organization_transfers.department_id', 'organization_departments.id')
                    ->join('organization_employees', 'organization_employees.id', '=', 'organization_transfers.employee_id')
                    ->where('organization_employees.use_classification', UseFlagEnum::USE)
                    ->where('organization_transfers.major_history_flg', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES)
                    ->where(function (Builder $query) {
                        EmployeeRepository::filterByDateConditions($query, Carbon::now());
                    });
            }])
            ->orderBy('organization_departments.display_order')
            ->get();
    }

    public function dropdownShinnichiroDepartment(): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->whereHas('company', function (EloquentBuilder $query) {
                $query->where('organization_companies.company_classification', CompanyClassificationEnum::SHINNICHIRO);
            })
            ->where('organization_departments.use_classification', UseFlagEnum::USE)
            ->select(Department::$selectProps)
            ->orderBy('organization_departments.display_order')
            ->get();
    }

    public function checkRelations(Department $department): Model|Department
    {
        return QueryBuilder::for($this->model())
            ->withCount('divisions')
            ->withCount('employees')
            ->withCount('customers')
            ->withCount('managementDepartments')
            ->find($department->id);
    }

}
