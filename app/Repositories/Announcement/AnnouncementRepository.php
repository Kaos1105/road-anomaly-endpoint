<?php

namespace App\Repositories\Announcement;

use App\Enums\Common\UseFlagEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Models\Announcement;
use App\Models\Display;
use App\Repositories\Announcement\Filter\FilterDisplayId;
use App\Repositories\Announcement\Sort\SortByAnnouncementsClassification;
use App\Repositories\Announcement\Sort\SortByContents;
use App\Repositories\Announcement\Sort\SortByDisplayOrder;
use App\Repositories\Announcement\Sort\SortByEndTime;
use App\Repositories\Announcement\Sort\SortByStartTime;
use App\Repositories\Announcement\Sort\SortByUpdateAt;
use App\Repositories\Display\Filter\FilterByCommonScreenCode;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class AnnouncementRepository extends BaseRepository implements IAnnouncementRepository
{
    use HasPagination;

    public function model(): string
    {
        return Announcement::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('system_id'),
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
            AllowedFilter::custom('display_id', new FilterDisplayId()),
        ];
    }

    protected array $allowedSorts = [
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('start_time', new SortByStartTime())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('end_time', new SortByEndTime())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('announcement_classification', new SortByAnnouncementsClassification())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('title', new SortByContents())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('updated_at', new SortByUpdateAt())->defaultDirection(SortDirection::DESCENDING),
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
            ->defaultSort(AllowedSort::custom('start_time', new SortByStartTime())->defaultDirection(SortDirection::DESCENDING))
            ->with(['system', 'display'])
            ->select(Announcement::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function getDetail(Announcement $announcement): Model|QueryBuilder
    {
        return $announcement->load(['system', 'display', 'createdBy', 'updatedBy']);
    }

    public function getAnnouncementBySubSystemId(int $systemId): Collection
    {
        $now = Carbon::now();
        return QueryBuilder::for($this->model())
            ->where([
                'system_id' => $systemId,
                'use_classification' => UseFlagEnum::USE
            ])
            ->where('start_time', '<=', $now)
            ->where(function (Builder $query) use ($now) {
                $query->whereNull('end_time')->orWhere('end_time', '>=', $now);
            })
            ->orderByDesc('start_time')
            ->with('display')
            ->get();
    }

    public function findPostingByDisplay(Display $display): Collection
    {
        $now = Carbon::now();
        return QueryBuilder::for($this->model())
            ->where([
                'system_id' => $display->system_id,
                'use_classification' => UseFlagEnum::USE
            ])
            ->where(function (Builder $query) use ($display) {
                $query->where('display_id', $display->id);
                if ($display->code != ScreenCodeEnum::LOGIN) {
                    $query->orWhere('display_id');
                }
            })
            ->where('start_time', '<=', $now)
            ->where(function (Builder $query) use ($now) {
                $query->whereNull('end_time')->orWhere('end_time', '>=', $now);
            })
            ->orderByDesc('start_time')
            ->get();
    }

}
