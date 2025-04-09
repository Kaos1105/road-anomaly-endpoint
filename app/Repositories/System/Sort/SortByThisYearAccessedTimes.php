<?php

namespace App\Repositories\System\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByThisYearAccessedTimes implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("this_year_accessed_times {$direction}")
            ->orderBy("code")
            ->orderBy("operation_classification")
            ->orderByDesc("updated_at");
    }
}
