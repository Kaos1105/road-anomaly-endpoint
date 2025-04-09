<?php

namespace App\Repositories\Site\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByCode implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("organization_sites.code {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("organization_sites.display_order")
            ->orderByDesc("organization_sites.updated_at");
    }
}
