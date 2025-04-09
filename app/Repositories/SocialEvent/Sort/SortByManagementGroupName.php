<?php

namespace App\Repositories\SocialEvent\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByManagementGroupName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->join("social_management_groups", "social_social_events.group_id", "=", "social_management_groups.id")
            ->orderByRaw("social_management_groups.name {$direction}")
            ->orderByDesc("planned_start")
            ->orderByDesc("planned_completion")
            ->orderByDesc("updated_at");
    }
}
