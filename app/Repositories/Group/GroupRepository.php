<?php

namespace App\Repositories\Group;

use App\Enums\Common\UseFlagEnum;
use App\Enums\Employee\AvatarFileEnum;
use App\Models\Group;
use App\Repositories\Group\Filter\FilterByRole;
use App\Repositories\Group\Sort\SortForAdmin;
use App\Repositories\Group\Sort\SortForUser;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class GroupRepository extends BaseRepository implements IGroupRepository
{
    use HasPagination;

    public function model(): string
    {
        return Group::class;
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
            ->select(Group::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                AllowedFilter::exact('use_classification'),
                AllowedFilter::custom('employee_id', new FilterByRole())
            ])
            ->allowedSorts([
                AllowedSort::custom('admin', new SortForAdmin()),
                AllowedSort::custom('user', new SortForUser()),
            ])
            ->select(Group::$selectProps)
            ->withCount('groupEmployees')
            ->with(['createdBy', 'updatedBy', 'employees' => function (BelongsToMany $query) {
                $query->orderBy('display_order');
            }, 'employees.attachmentFiles' => function (MorphMany $query) {
                $query->where('file_name', 'LIKE', AvatarFileEnum::FILE_NAME . '%');
            }])
            ->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                AllowedFilter::exact('use_classification'),
                AllowedFilter::custom('employee_id', new FilterByRole())
            ])
            ->allowedSorts([
                AllowedSort::custom('admin', new SortForAdmin()),
                AllowedSort::custom('user', new SortForUser()),
            ])
            ->select(Group::$selectProps)
            ->withCount('groupEmployees')
            ->with(['updatedBy', 'employees' => function (BelongsToMany $query) {
                $query->orderBy('display_order');
            }, 'employees.attachmentFiles' => function (MorphMany $query) {
                $query->where('file_name', 'LIKE', AvatarFileEnum::FILE_NAME . '%');
            }])->get();
    }

    public function getDetail(Group $group): Model|QueryBuilder
    {
        return $group->load(['createdBy', 'updatedBy', 'employees']);
    }

    public function getGroupsInUse(): Collection
    {
        return QueryBuilder::for($this->model())
            ->where('use_classification', UseFlagEnum::USE)
            ->select(Group::$selectProps)
            ->orderBy('display_order')
            ->get();
    }

    public function getGroupBothEmployeeAndUser(): Collection
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                AllowedFilter::custom('user_id', new FilterByRole()),
                AllowedFilter::custom('employee_id', new FilterByRole()),
                AllowedFilter::exact('use_classification')
            ])
            ->select(Group::$selectProps)
            ->get();
    }

}
