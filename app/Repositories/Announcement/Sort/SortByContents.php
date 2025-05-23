<?php

namespace App\Repositories\Announcement\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByContents implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("title {$direction}")
            ->orderByDesc("content")
            ->orderByDesc("start_time")
            ->orderByDesc("updated_at");
    }
}
