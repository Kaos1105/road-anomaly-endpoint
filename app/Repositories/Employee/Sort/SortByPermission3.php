<?php

namespace App\Repositories\Employee\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByPermission3 implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("access_permission_3 {$direction}")
            ->orderByDesc("access_permission_1")
            ->orderBy("display_order")
            ->orderBy("access_permission_start_date");
    }
}
