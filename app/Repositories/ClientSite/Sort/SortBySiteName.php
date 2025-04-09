<?php

namespace App\Repositories\ClientSite\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySiteName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("site_name {$direction}")
            ->orderBy("negotiation_client_sites.display_order")
            ->orderByDesc("negotiation_client_sites.updated_at");
    }
}
