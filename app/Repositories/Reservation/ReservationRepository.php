<?php

namespace App\Repositories\Reservation;

use App\Models\Facility;
use App\Models\Reservation;
use App\Trait\HasPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReservationRepository extends BaseRepository implements IReservationRepository
{
    use HasPagination;

    public function model(): string
    {
        return Reservation::class;
    }

    protected string $defaultSort = 'reservation_date';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('facility_id'),
            AllowedFilter::exact('use_person_id'),
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
        'display_order'
    ];

    protected function allowedCustomSorts(): array
    {
        return [];
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
            ->select(Reservation::$selectProps);
    }

    public function findByQuery(QueryBuilder $query): Collection
    {
        return $query->select(Reservation::$selectProps)
            ->with(['facility', 'usePerson'])
            ->orderByDesc('updated_at')->get();
    }

    public function getUserLatestReservation(int $facilityGroupId, int $facilityClassification): Reservation|null
    {
        $employeeId = \Auth::user()->employee_id;
        return Reservation::query()->where('created_by', $employeeId)
            ->whereHas('facility', function (Builder $query) use ($facilityGroupId, $facilityClassification) {
                $query->where('facility_group_id', $facilityGroupId)
                    ->where('facility_classification', $facilityClassification);
            })
            ->orderByDesc('updated_at')->limit(1)->get(Reservation::$selectProps)->first();
    }
}
