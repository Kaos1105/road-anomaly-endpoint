<?php

namespace App\Repositories\Group\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class SortForAdmin implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $query->orderByDesc('main_groups.use_classification')
            ->orderByRaw(
                '(SELECT COUNT(*) FROM main_group_members WHERE main_group_members.employee_id = ? AND main_group_members.group_id = main_groups.id) DESC',
                [\Auth::user()->employee_id]
            )
            ->orderBy('main_groups.display_order');
    }
}
