<?php

namespace App\Repositories\Site\Sort\Company;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySiteClassification implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("site_classification {$direction}")
            ->orderByDesc("count_favorites")
            ->orderBy("display_order")
            ->orderBy("updated_at");
    }
}
