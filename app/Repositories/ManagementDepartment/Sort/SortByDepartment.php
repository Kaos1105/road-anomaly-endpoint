<?php

namespace App\Repositories\ManagementDepartment\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDepartment implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("organization_departments.long_name {$direction}")
            ->orderBy("organization_departments.code")
            ->orderBy("organization_departments.display_order")
            ->orderByDesc("negotiation_management_departments.updated_at");
    }
}
