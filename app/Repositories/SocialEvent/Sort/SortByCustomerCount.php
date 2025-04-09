<?php

namespace App\Repositories\SocialEvent\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByCustomerCount implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("customer_count {$direction}")
            ->orderByDesc("planned_start")
            ->orderByDesc("planned_completion")
            ->orderByDesc("updated_at");
    }
}
