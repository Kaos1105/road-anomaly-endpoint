<?php

namespace App\Repositories\AccessHistory\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySystemDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("snet_systems.display_order {$direction}")
            ->orderByDesc("snet_access_histories.id");
    }
}
