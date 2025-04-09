<?php

namespace App\Repositories\Company\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySiteAddress implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("site_address_1 {$direction}")
            ->orderByRaw("site_address_2 {$direction}")
            ->orderByRaw("site_address_3 {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("display_order")
            ->orderByDesc("updated_at");
    }
}
