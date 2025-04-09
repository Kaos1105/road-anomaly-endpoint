<?php

namespace App\Repositories\ClientSite\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("negotiation_client_sites.display_order {$direction}")
            ->orderBy("company_name")
            ->orderByDesc("negotiation_client_sites.updated_at");
    }
}
