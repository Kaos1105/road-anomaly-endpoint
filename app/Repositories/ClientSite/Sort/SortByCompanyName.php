<?php

namespace App\Repositories\ClientSite\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByCompanyName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("company_name {$direction}")
            ->orderBy("negotiation_client_sites.display_order")
            ->orderByDesc("negotiation_client_sites.updated_at");
    }
}
