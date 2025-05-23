<?php

namespace App\Repositories\Site\Sort\Company;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySiteDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("display_order {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("updated_at");
    }
}
