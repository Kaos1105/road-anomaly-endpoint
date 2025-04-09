<?php

namespace App\Repositories\Display;

use App\Enums\Common\UseFlagEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Models\AccessPermission;
use App\Models\Display;
use App\Query\FAQ\QuestionDropdownQuery;
use App\Repositories\Display\Filter\FilterByCommonScreenCode;
use App\Repositories\Display\Filter\FilterByScreenCode;
use App\Repositories\Display\Filter\FilterBySystemCode;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DisplayRepository extends BaseRepository implements IDisplayRepository
{
    use HasPagination;

    public function model(): string
    {
        return Display::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('system_id'),
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
            AllowedFilter::custom('common_screen_codes', new FilterByCommonScreenCode())
        ];
    }

    protected array $allowedSorts = [
        'updated_at',
        'display_order',
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
            ->select(Display::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function getList(): Collection
    {
        return QueryBuilder::for(Display::class)
            ->allowedFilters([
                ...$this->allowedFilters,
                ...$this->allowedExactFilters(),
                ...$this->allowedScopedFilters(),
                ...$this->allowedCustomFilters()
            ])
            ->with(['system', 'contents' => function (HasMany $contentQuery) {
                $contentQuery->where('use_classification', UseFlagEnum::USE);
            }])->orderBy('display_order')->get();
    }

    public function showDetail(Display $detail): Display
    {
        return $detail->load(['createdBy', 'updatedBy', 'system']);
    }

    public function findDisplay(int $displayId): Display|null
    {
        return Display::find($displayId);
    }

    public function findDisplayByCode(string $screenCode, int $isUse = null): Display|null
    {
        $condition = ['code' => $screenCode];
        if ($isUse) {
            $condition['use_classification'] = $isUse;
        }
        return Display::where($condition)->first();
    }

    public function queryQuestionPermission(Builder|HasMany $query, Collection $userPermission): Builder|HasMany
    {
        return $query->where('snet_questions.use_classification', UseFlagEnum::USE)
            ->where(function (Builder $query) use ($userPermission) {
                $userPermission->each(function (AccessPermission $permission) use ($query) {
                    $query->orWhere(function (Builder $q) use ($permission) {
                        $q->whereHas('display', function (Builder $displayQuery) use ($permission) {
                            $displayQuery->where('system_id', $permission->system_id);
                        })
                            ->where('permission_2', '<=', $permission->permission_2)
                            ->where('permission_3', '<=', $permission->permission_3)
                            ->where('permission_4', '<=', $permission->permission_4);
                    });
                });
            })->orderBy('snet_questions.display_order');
    }

    public function getListQuestions(QuestionDropdownQuery $query, Collection $userPermission): Collection
    {
        $filter = request()->input('filter');
        if ($filter && !empty($filter['search'])) {
            $query = $query
                ->whereHas('questions', function (Builder $query) use ($userPermission) {
                    $this->queryQuestionPermission($query, $userPermission);
                })
                ->with(['questions' => function (HasMany $hasMany) use ($userPermission, $filter) {
                    $hasMany->where('title', 'LIKE', '%' . $filter['search'] . '%');
                    $this->queryQuestionPermission($hasMany, $userPermission);
                }]);
        } else {
            $query = $query->with(['questions' => function (HasMany $hasMany) use ($userPermission, $filter) {
                $this->queryQuestionPermission($hasMany, $userPermission);
            }]);
        }
        return $query
            ->where('snet_displays.use_classification', UseFlagEnum::USE)
            ->orderBy('snet_displays.display_order')
            ->get();
    }

    public function checkRelations(Display $display): Model|Display
    {
        return QueryBuilder::for($this->model())
            ->withCount('questions')
            ->find($display->id);
    }

    public function deleteMultiple(array $ids): void
    {
        Display::whereIn('id', $ids)->delete();
    }

    public function getDataExport(): Collection
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                AllowedFilter::custom('system_code', new FilterBySystemCode()),
                AllowedFilter::custom('screen_code', new FilterByScreenCode())
            ])
            ->orderBy('display_order')
            ->get();
    }
}
