<?php

namespace App\Repositories\ManagementGroup;

use App\Enums\Common\UseFlagEnum;
use App\Models\CustomerCategory;
use App\Models\ManagementGroup;
use App\Query\ManagementGroup\ManagementGroupDropdownQuery;
use App\Trait\HasPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class ManagementGroupRepository extends BaseRepository implements IManagementGroupRepository
{
    use HasPagination;

    public function model(): string
    {
        return ManagementGroup::class;
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
        'updated_at',
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
            ->select(ManagementGroup::$selectProps);
    }

    public function getList(): Collection
    {
        return $this->filters()->get();
    }

    public function showDetail(ManagementGroup $detail): ManagementGroup
    {
        return $detail->load([
            'customerCategories',
            'createdBy',
            'updatedBy',
            'preparatoryPersonnel',
            'applicant',
            'approver',
            'finalDecisionMaker',
            'orderingPersonnel',
            'paymentPersonnel',
            'completionPersonnel',
            'socialEvents' => function (HasMany $socialEventQuery) {
                $socialEventQuery->where('use_classification', UseFlagEnum::USE)
                    ->with(['eventClassification', 'socialData.workflows'])->orderByDesc('planned_start')->limit(10);
            }
        ]);
    }

    /**
     * @throws Throwable
     */
    public function createManagementGroup(array $attributes): ManagementGroup|Model|null
    {
        DB::beginTransaction();
        try {
            $managementGroup = $this->create($attributes);
            $managementGroup->customerCategories()->createMany($attributes['categories']);
            DB::commit();
            return $this->showDetail($managementGroup);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @throws Throwable
     */
    public function updateManagementGroup(array $attributes, ManagementGroup $managementGroup): ManagementGroup|Model|null
    {
        DB::beginTransaction();
        try {
            $managementGroup = $this->update($attributes, $managementGroup->id);
            $managementGroup->customerCategories()->delete();
            $managementGroup->customerCategories()->createMany($attributes['categories']);
            DB::commit();
            return $this->showDetail($managementGroup);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function dropdownCustomerCategory(): Collection|array|null
    {
        return QueryBuilder::for(CustomerCategory::class)
            ->defaultSort('id')
            ->select('name')->distinct()
            ->get();
    }

    public function findByQuery(ManagementGroupDropdownQuery $query): Collection|array
    {
        return $query->select(ManagementGroup::$selectProps)->orderBy($this->defaultSort)->get();
    }

    public function checkRelations(ManagementGroup $employee): Model|ManagementGroup
    {
        return QueryBuilder::for($this->model())
            ->withCount('socialEvents')
            ->find($employee->id);
    }

    public function numberOfRecordInUse(): int
    {
        return ManagementGroup::where('use_classification', UseFlagEnum::USE)->count();
    }

    public function getDashboardList(): Collection
    {
        return $this->filters()->withCount(['socialEvents' => function (Builder $socialEventQuery) {
            $socialEventQuery->where('use_classification', UseFlagEnum::USE);
        }])->get();
    }
}
