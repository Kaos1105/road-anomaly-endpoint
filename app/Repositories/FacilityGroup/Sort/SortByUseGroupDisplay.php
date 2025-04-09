<?php

namespace App\Repositories\FacilityGroup\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByUseGroupDisplay implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("use_group_display_order {$direction}")
            ->orderBy("facility_facility_groups.display_order")
            ->orderByDesc("facility_facility_groups.updated_at");
    }
}
