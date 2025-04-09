<?php

namespace App\Repositories\Announcement\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByAnnouncementsClassification implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("announcement_classification {$direction}")
            ->orderByDesc("start_time")
            ->orderByDesc("end_time")
            ->orderByDesc("updated_at");
    }
}
