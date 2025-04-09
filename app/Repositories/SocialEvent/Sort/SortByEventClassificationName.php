<?php

namespace App\Repositories\SocialEvent\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByEventClassificationName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->join("social_event_classifications", "social_social_events.event_id", "=", "social_event_classifications.id")
            ->orderByRaw("social_event_classifications.name {$direction}")
            ->orderByDesc("planned_start")
            ->orderByDesc("planned_completion")
            ->orderByDesc("updated_at");
    }
}
