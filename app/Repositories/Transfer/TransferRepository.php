<?php

namespace App\Repositories\Transfer;

use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Models\Employee;
use App\Models\Transfer;
use App\Repositories\Transfer\Sort\SortByCompany;
use App\Repositories\Transfer\Sort\SortByDepartment;
use App\Repositories\Transfer\Sort\SortByDivision;
use App\Repositories\Transfer\Sort\SortByMajorHistoryFlg;
use App\Repositories\Transfer\Sort\SortByNo;
use App\Repositories\Transfer\Sort\SortByPeriod;
use App\Repositories\Transfer\Sort\SortByPosition;
use App\Repositories\Transfer\Sort\SortBySite;
use App\Trait\ActivePeriodQuery;
use App\Trait\HasPagination;
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

class TransferRepository extends BaseRepository implements ITransferRepository
{
    use HasPagination, ActivePeriodQuery;

    public function model(): string
    {
        return Transfer::class;
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
            ->select(Transfer::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function showDetail(Transfer $transfer): Model|QueryBuilder
    {
        return $transfer->load(['company', 'site', 'department', 'division', 'employee', 'createdBy', 'updatedBy']);
    }

    public function getTransfersByEmployee(Employee $employee): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->where('organization_transfers.employee_id', $employee->id)
            ->allowedSorts([
                ...$this->allowedSorts,
                AllowedSort::custom('no', new SortByNo())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('start_date', new SortByPeriod())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('position', new SortByPosition())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('major_history_flg', new SortByMajorHistoryFlg())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('company', new SortByCompany())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('site', new SortBySite())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('department', new SortByDepartment())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('division', new SortByDivision())->defaultDirection(SortDirection::ASCENDING)
            ])
            ->defaultSort(AllowedSort::custom('no', new SortByPeriod())->defaultDirection(SortDirection::ASCENDING))
            ->select(Transfer::$selectProps)
            ->with(['site', 'company', 'department', 'division', 'employee'])
            ->get();
    }

    /**
     * @throws ValidatorException
     */
    public function setRepresentativeTransfer(Transfer $transfer, array $dataUpdate): void
    {
        $previousRepresentative = Transfer::where([
            'company_id' => $transfer->company_id,
            'represent_flg' => RepresentFlagEnum::REPRESENTATIVE
        ])->first();

        if ($previousRepresentative) {
            $this->update([...$dataUpdate, 'represent_flg' => RepresentFlagEnum::NOT_SPECIFIED], $previousRepresentative->id);
        }
        $this->update([...$dataUpdate, 'represent_flg' => RepresentFlagEnum::REPRESENTATIVE], $transfer->id);
    }

    public function getTransfersByEmployeeSocial(Employee $employee): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->where('organization_transfers.employee_id', $employee->id)
            ->allowedSorts([
                ...$this->allowedSorts,
                AllowedSort::custom('no', new SortByNo())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('start_date', new SortByPeriod())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('company', new SortByCompany())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('site', new SortBySite())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('department', new SortByDepartment())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('division', new SortByDivision())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::custom('position', new SortByPosition())->defaultDirection(SortDirection::ASCENDING),
                AllowedSort::field('updated_at')->defaultDirection(SortDirection::DESCENDING)

            ])
            ->allowedFilters([
                AllowedFilter::exact('major_history_flg'),
            ])
            ->defaultSort(AllowedSort::custom('no', new SortByNo())->defaultDirection(SortDirection::ASCENDING))
            ->select(Transfer::$selectProps)
            ->with(['site', 'company', 'department', 'division', 'employee'])
            ->get();
    }

    public function checkRelations(Transfer $transfer): Model|Transfer
    {
        return QueryBuilder::for($this->model())
            ->withCount('customer')
            ->find($transfer->id);
    }

    public function getActiveTransferForCustomer(): Collection
    {
        return Transfer::query()
            ->whereNotNull('department_id')
            ->where(function (EloquentBuilder $query) {
                $this->activePeriodConditions($query, 'organization_transfers');
            })
            ->whereHas('employee', function (EloquentBuilder $employeeQuery) {
                $employeeQuery->where('organization_employees.use_classification', UseFlagEnum::USE);
            })
            ->get();
    }

    public function getActiveTransferForSupplier(): Collection
    {
        return Transfer::query()
            ->where(function (EloquentBuilder $query) {
                $this->activePeriodConditions($query, 'organization_transfers');
            })
            ->whereHas('employee', function (EloquentBuilder $employeeQuery) {
                $employeeQuery->where('organization_employees.use_classification', UseFlagEnum::USE);
            })
            ->whereHas('site', function (EloquentBuilder $siteQuery) {
                $siteQuery->where('organization_sites.use_classification', UseFlagEnum::USE);
                $this->activePeriodConditions($siteQuery, 'organization_sites');
            })
            ->whereHas('company', function (EloquentBuilder $companyQuery) {
                $companyQuery->where('organization_companies.use_classification', UseFlagEnum::USE)
                    ->where('organization_sites.site_classification', CompanyClassificationEnum::SUPPLIER);;
                $this->activePeriodConditions($companyQuery, 'organization_companies');
            })
            ->get();
    }

}
