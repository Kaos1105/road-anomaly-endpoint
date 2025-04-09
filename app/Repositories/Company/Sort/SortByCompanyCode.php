<?php

namespace App\Repositories\Company\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByCompanyCode implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("code {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("display_order")
            ->orderByDesc("updated_at");
    }
}
