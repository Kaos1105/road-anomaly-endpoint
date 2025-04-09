<?php

namespace App\Repositories\ManagementDepartment\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByManagementDepartment implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("negotiation_management_departments.name {$direction}")
            ->orderBy("negotiation_management_departments.display_order")
            ->orderByDesc("negotiation_management_departments.updated_at");
    }
}
