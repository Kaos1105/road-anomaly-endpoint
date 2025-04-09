<?php

namespace App\Repositories\Content\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("snet_contents.display_order {$direction}")
            ->orderBy("snet_contents.no")
            ->orderByDesc("snet_contents.updated_at");
    }
}
