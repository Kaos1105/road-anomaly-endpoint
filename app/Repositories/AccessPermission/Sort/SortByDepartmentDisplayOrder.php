<?php

namespace App\Repositories\AccessPermission\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDepartmentDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("department_display_order {$direction}")
            ->orderBy("start_date")
            ->orderBy("end_date")
            ->orderBy("access_at");
    }
}
