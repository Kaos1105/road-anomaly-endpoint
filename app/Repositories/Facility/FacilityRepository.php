<?php

namespace App\Repositories\Facility;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Employee\AvatarFileEnum;
use App\Models\Facility;
use App\Models\FacilityGroup;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FacilityRepository extends BaseRepository implements IFacilityRepository
{
    use HasPagination;

    public function model(): string
    {
        return Facility::class;
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
            ->select(Facility::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(FacilityGroup $facilityGroup): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->where('facility_group_id', $facilityGroup->id)
            ->with('responsibleUser')
            ->orderBy('facility_classification')
            ->orderBy('display_order')
            ->get();
    }

    public function checkRelations(Facility $facility): Model|Facility
    {
        return QueryBuilder::for($this->model())
            ->withCount('reservations')
            ->find($facility->id);
    }

    public function getDetail(Facility $facility): Model|QueryBuilder
    {
        return $facility->load(['createdBy', 'updatedBy', 'facilityGroup.useGroup', 'responsibleUser']);
    }

    public function getList(QueryBuilder $query, array $calendarDates): Collection
    {
        return $query
            ->where('use_classification', UseFlagEnum::USE)
            ->addSelect(Facility::$selectProps)->with(['reservations' => function (HasMany $subQuery) use ($calendarDates) {
                $subQuery->whereIn('reservation_date', $calendarDates)
                    ->with(['createdBy', 'updatedBy', 'usePerson'])->orderBy('reservation_date')->orderBy('start_time')->orderBy('id');
            },
                'attachmentFiles' => function (MorphMany $query) {
                    $query->where('file_name', 'LIKE', AvatarFileEnum::FILE_NAME . '%');
                }])
            ->orderBy('facility_classification')
            ->orderBy('display_order')
            ->get();
    }

    public function getFacilityReservationPortal(int $facilityGroupId): Collection
    {
        return QueryBuilder::for($this->model())
            ->where('facility_group_id', $facilityGroupId)
            ->where('use_classification', UseFlagEnum::USE)
            ->with('reservations', function ($query) {
                $today = Carbon::now();
                $query->with('usePerson')->where('reservation_date', $today->clone()->format(DateTimeEnum::DATE_FORMAT_V2))
                    ->where('start_time', '<=', $today->clone()->addHour()->format(DateTimeEnum::TIME_FORMAT_V2))
                    ->where('end_time', '>=', $today->clone()->format(DateTimeEnum::TIME_FORMAT_V2))
                    ->orderBy('updated_at');
            })
            ->orderBy('display_order')
            ->get();
    }
}
