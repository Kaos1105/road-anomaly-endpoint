<?php

namespace App\Repositories\FacilityGroup;

use App\Enums\Common\UseFlagEnum;
use App\Enums\Facility\AggregationClassificationEnum;
use App\Models\FacilityGroup;
use App\Models\FacilityUserSetting;
use App\Models\Group;
use App\Repositories\FacilityGroup\Sort\SortByDisplayOrder;
use App\Repositories\FacilityGroup\Sort\SortByName;
use App\Repositories\FacilityGroup\Sort\SortByNumberFacilities;
use App\Repositories\FacilityGroup\Sort\SortByUseGroupDisplay;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as BuilderQuery;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FacilityGroupRepository extends BaseRepository implements IFacilityGroupRepository
{
    use HasPagination;

    public function model(): string
    {
        return FacilityGroup::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
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
        return [];
    }

    protected array $allowedSorts = [
        'updated_at',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('name', new SortByName()),
            AllowedSort::custom('number_of_facilities', new SortByNumberFacilities()),
            AllowedSort::custom('use_group', new SortByUseGroupDisplay()),
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
            ->select(FacilityGroup::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->withCount(['facilities' => function ($query) {
                $query->where('aggregation_classification', AggregationClassificationEnum::AGGREGATION);
            }])
            ->with('useGroup')
            ->addSelect(['use_group_display_order' => function (BuilderQuery $query) {
                $query->select('main_groups.display_order')
                    ->from('main_groups')
                    ->whereColumn('main_groups.id', 'facility_facility_groups.use_group_id');
            }])
            ->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function getDetail(FacilityGroup $facilityGroup): Model|QueryBuilder
    {
        return $facilityGroup->load(['createdBy', 'updatedBy', 'useGroup']);
    }

    public function checkRelations(FacilityGroup $facilityGroup): Model|FacilityGroup|null
    {
        return QueryBuilder::for($this->model())
            ->withCount('facilities')
            ->withCount('userSettings')
            ->find($facilityGroup->id);
    }

    public function findByQuery(QueryBuilder $query): Collection
    {
        return $query->select(FacilityGroup::$selectProps)->orderBy($this->defaultSort)->get();
    }

    public function countPortalData(): int
    {
        return QueryBuilder::for($this->model())->whereHas('useGroup', function ($query) {
            $query->whereHas('groupEmployees', function ($query) {
                $query->where('employee_id', Auth::user()->employee_id);
            });
        })->count();
    }

    public function dropdownFacilityGroupUserSetting(): Collection|array
    {
        $useGroupIds = Group::whereHas('groupEmployees', function (Builder $query) {
            $query->where('employee_id', Auth::user()->employee_id);
        })->get('id')->pluck('id');

        $userSetting = FacilityUserSetting::where('user_id', Auth::user()->employee_id)->first();
        return QueryBuilder::for($this->model())
            ->where('id', $userSetting?->facility_group_id)
            ->orWhere(function (Builder $query) use ($useGroupIds) {
                $query->where('use_classification', UseFlagEnum::USE)
                    ->whereIn('facility_facility_groups.use_group_id', $useGroupIds)
                    ->whereHas('facilities', function (Builder $query) {
                        $query->where('use_classification', UseFlagEnum::USE);
                    });
            })
            ->orderBy('display_order')
            ->orderBy('created_at')
            ->get();
    }
}
