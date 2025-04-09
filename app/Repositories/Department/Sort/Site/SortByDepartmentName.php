<?php

namespace App\Repositories\Department\Sort\Site;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDepartmentName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("organization_departments.kana {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("organization_departments.display_order")
            ->orderByDesc("organization_departments.updated_at");
    }
}
