<?php

namespace App\Repositories\Content;

use App\Enums\Common\UseFlagEnum;
use App\Enums\ScreenName\ContentClassificationEnum;
use App\Models\Content;
use App\Repositories\Content\Filter\FilterByScreenCode;
use App\Repositories\Content\Filter\FilterBySystemCode;
use App\Repositories\Content\Sort\SortByContentName;
use App\Repositories\Content\Sort\SortByContentNo;
use App\Repositories\Content\Sort\SortByDisplayOrder;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class ContentRepository extends BaseRepository implements IContentRepository
{
    use HasPagination;

    public function model(): string
    {
        return Content::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('display_id'),
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
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('no', new SortByContentNo())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('name', new SortByContentName())->defaultDirection(SortDirection::ASCENDING),
            AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::ASCENDING),
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
            ->defaultSort(AllowedSort::custom('no', new SortByContentNo())->defaultDirection(SortDirection::ASCENDING))
            ->select(Content::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function getList(): Collection
    {
        return $this->filters()->get();
    }

    public function showDetail(Content $detail): Content
    {
        return $detail->load(['createdBy', 'updatedBy', 'display.system']);
    }

    public function getListByDisplay(int $displayId): Collection
    {
        return QueryBuilder::for($this->model())
            ->where([
                'display_id' => $displayId,
                'use_classification' => UseFlagEnum::USE
            ])
            ->select(Content::$selectProps)
            ->defaultSort(AllowedSort::custom('no', new SortByContentNo())->defaultDirection(SortDirection::ASCENDING))
            ->get();
    }

    public function getListCardByDisplay(int $displayId): Collection
    {
        return Content::where([
            'classification' => ContentClassificationEnum::CARD,
            'use_classification' => UseFlagEnum::USE,
            'display_id' => $displayId
        ])
            ->select(Content::$selectProps)
            ->orderBy('no')
            ->get();
    }

    public function findByScreenContentNo(string $displayCode, string $contentNo): Content|null
    {
        return Content::where([
            'no' => $contentNo
        ])->whereHas('display', function ($query) use ($displayCode) {
            $query->where('code', $displayCode);
        })->first();
    }

    public function deleteMultiple(array $ids): void
    {
        Content::whereIn('id', $ids)->delete();
    }

    public function getDataExport(): Collection
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                AllowedFilter::custom('system_code', new FilterBySystemCode()),
                AllowedFilter::custom('screen_code', new FilterByScreenCode())
            ])
            ->get();
    }

}
