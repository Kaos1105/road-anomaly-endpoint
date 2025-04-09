<?php

namespace App\Repositories\FacilityGroup\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByNumberFacilities implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("facilities_count {$direction}")
            ->orderBy("facility_facility_groups.display_order")
            ->orderBy("facility_facility_groups.name")
            ->orderByDesc("facility_facility_groups.updated_at");
    }
}
