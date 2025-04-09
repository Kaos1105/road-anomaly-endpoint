<?php

namespace App\Repositories\Product\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("social_products.display_order {$direction}")
            ->orderBy("social_products.code")
            ->orderByDesc("social_products.updated_at");
    }
}
