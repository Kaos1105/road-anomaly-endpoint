<?php

namespace App\Repositories\Site\Sort\Company;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySiteName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("long_name {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("display_order")
            ->orderBy("updated_at");
    }
}
