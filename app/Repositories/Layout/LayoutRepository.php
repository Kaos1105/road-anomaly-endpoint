<?php

namespace App\Repositories\Layout;

use App\Models\Layout;
use App\Trait\HasPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LayoutRepository extends BaseRepository implements ILayoutRepository
{
    use HasPagination;

    public function model(): string
    {
        return Layout::class;
    }

    protected string $defaultSort = 'block_order';

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
            ->select(Layout::$selectProps);
    }

    public function findLayoutByEmployee(int $systemId, int $employeeId, ?array $contentsNo = null): Collection
    {
        return QueryBuilder::for($this->model())
            ->where([
                'system_id' => $systemId,
                'employee_id' => $employeeId,
            ])->where(function (Builder $query) use ($contentsNo) {
                if ($contentsNo) {
                    $query->whereIn('content_no', $contentsNo);
                }
            })
            ->orderBy('block_order')
            ->orderBy('block')
            ->get();
    }

    public function createLayoutEmployee(array $dataInsert): bool
    {
        return Layout::insert($dataInsert);
    }

    public function updateLayoutEmployee(array $dataUpdate): int
    {
        return Layout::upsert($dataUpdate, ['id']);
    }

    public function deleteLayoutEmployee(int $systemId, int $employeeId, ?array $contentsNo = null): int
    {
        return Layout::where([
            'system_id' => $systemId,
            'employee_id' => $employeeId,
        ])->whereIn('content_no', $contentsNo)->delete();
    }

    public function findLayoutBlock(int $systemId, int $employeeId, string $block, int $blockOrderStart, ?int $blockOrderEnd = null): Collection
    {
        return QueryBuilder::for($this->model())
            ->where([
                'system_id' => $systemId,
                'employee_id' => $employeeId,
                'block' => $block
            ])
            ->where(function (Builder $query) use ($blockOrderStart, $blockOrderEnd) {
                $query->where('block_order', '>=', $blockOrderStart);
                if ($blockOrderEnd) {
                    $query->where('block_order', '<=', $blockOrderEnd);
                }
            })
            ->orderBy('block_order')
            ->get();
    }
}
