<?php

namespace App\Repositories\FAQ\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByCode implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("snet_questions.code {$direction}")
            ->orderBy("snet_questions.display_order")
            ->orderByDesc("snet_questions.updated_at");
    }
}
