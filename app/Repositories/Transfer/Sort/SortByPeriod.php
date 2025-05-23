<?php

namespace App\Repositories\Transfer\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByPeriod implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("organization_transfers.start_date {$direction}")
            ->orderBy("organization_transfers.display_order")
            ->orderByDesc("organization_transfers.updated_at");
    }
}
