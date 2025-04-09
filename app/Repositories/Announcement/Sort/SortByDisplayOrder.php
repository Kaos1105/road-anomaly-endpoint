<?php

namespace App\Repositories\Announcement\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByDisplayOrder implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->leftJoin("snet_displays", "snet_announcements.display_id", "=", "snet_displays.id")
            ->select("snet_announcements.*")
            ->orderByRaw("snet_displays.display_order {$direction}")
            ->orderByDesc("snet_announcements.start_time")
            ->orderByDesc("snet_announcements.end_time")
            ->orderByDesc("snet_announcements.updated_at");
    }
}
