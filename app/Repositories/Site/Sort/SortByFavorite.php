<?php

namespace App\Repositories\Site\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByFavorite implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("count_favorites {$direction}")
            ->orderBy("organization_sites.display_order")
            ->orderByDesc("organization_sites.updated_at");
    }
}
