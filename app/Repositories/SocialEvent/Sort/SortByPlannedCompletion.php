<?php

namespace App\Repositories\SocialEvent\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByPlannedCompletion implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("social_social_events.planned_completion {$direction}")
            ->orderByDesc("planned_start")
            ->orderByDesc("updated_at");
    }
}
