<?php

namespace App\Repositories\AccessPermission\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByEmployeeDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("organization_employees.display_order {$direction}")
            ->orderBy("snet_access_permissions.start_date")
            ->orderBy("snet_access_permissions.end_date")
            ->orderBy("access_at");
    }
}
