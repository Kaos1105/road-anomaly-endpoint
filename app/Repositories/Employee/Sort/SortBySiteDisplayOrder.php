<?php

namespace App\Repositories\Employee\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySiteDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("site_display_order {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("organization_employees.display_order")
            ->orderByDesc("organization_employees.updated_at");
    }
}
