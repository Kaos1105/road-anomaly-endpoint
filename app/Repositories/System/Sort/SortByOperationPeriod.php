<?php

namespace App\Repositories\System\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByOperationPeriod implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("end_date {$direction}")
            ->orderBy("code")
            ->orderBy("operation_classification")
            ->orderByDesc("updated_at");
    }
}
