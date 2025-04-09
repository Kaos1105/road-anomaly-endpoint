<?php

namespace App\Repositories\Division\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDivisionName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("organization_divisions.kana {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("organization_divisions.display_order")
            ->orderByDesc("organization_divisions.updated_at");
    }
}
