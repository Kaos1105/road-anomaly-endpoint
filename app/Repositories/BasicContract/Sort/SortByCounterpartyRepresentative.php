<?php

namespace App\Repositories\BasicContract\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByCounterpartyRepresentative implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("counterparty_representative_display_order {$direction}")
            ->orderBy("display_order")
            ->orderByDesc("updated_at");
    }
}
