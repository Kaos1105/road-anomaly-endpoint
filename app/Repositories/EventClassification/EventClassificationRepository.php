<?php

namespace App\Repositories\EventClassification;

use App\Enums\Common\UseFlagEnum;
use App\Models\EventClassification;
use App\Query\EventClassification\EventClassificationDropdownQuery;
use App\Trait\HasPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EventClassificationRepository extends BaseRepository implements IEventClassificationRepository
{
    use HasPagination;

    public function model(): string
    {
        return EventClassification::class;
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
            ->select(EventClassification::$selectProps);
    }

    public function getList(): Collection
    {
        return $this->filters()->get();
    }

    public function showDetail(EventClassification $detail): EventClassification
    {
        return $detail->load(['createdBy', 'updatedBy',
            'socialEvents' => function (HasMany $socialEventQuery) {
                $socialEventQuery->where('use_classification', UseFlagEnum::USE)
                    ->with(['managementGroup', 'socialData.workflows'])->orderByDesc('planned_start')->limit(10);
            }]);
    }

    public function findByQuery(EventClassificationDropdownQuery $query): Collection|array
    {
        return $query->select(EventClassification::$selectProps)->orderBy($this->defaultSort)->get();
    }

    public function checkRelations(EventClassification $eventClassification): EventClassification|Model
    {
        return QueryBuilder::for($this->model())
            ->withCount('socialEvents')
            ->find($eventClassification->id);
    }

    public function getDashboardList(): Collection
    {
        return $this->filters()->withCount(['socialEvents' => function (Builder $socialEventQuery) {
            $socialEventQuery->where('use_classification', UseFlagEnum::USE);
        }])->get();
    }

    public function numberOfRecordInUse(): int
    {
        return EventClassification::where('use_classification', UseFlagEnum::USE)->count();
    }
}
