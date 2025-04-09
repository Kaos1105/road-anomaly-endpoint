<?php

namespace App\Repositories\ContractWorkplace\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByWorkplaceName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("workplace_name {$direction}")
            ->orderBy("display_order")
            ->orderByDesc("updated_at");
    }
}
