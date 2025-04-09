<?php

namespace App\Repositories\Employee\Sort\SelectEmployee;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByPosition implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->orderByRaw("transfer_position {$direction}")
            ->orderBy("organization_employees.kana")
            ->orderByDesc("organization_employees.updated_at");
    }
}
