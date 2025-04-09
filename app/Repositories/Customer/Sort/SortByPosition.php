<?php

namespace App\Repositories\Customer\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByPosition implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->join("organization_transfers", "social_customers.display_transfer_id", "=", "organization_transfers.id")
            ->orderByRaw("organization_transfers.position {$direction}")
            ->orderBy("social_customers.display_order")
            ->orderByDesc("social_customers.updated_at");
    }
}
