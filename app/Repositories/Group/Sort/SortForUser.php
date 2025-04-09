<?php

namespace App\Repositories\Group\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class SortForUser implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $query->orderByDesc("main_groups.use_classification")
            ->orderBy("main_groups.display_order");
    }
}
