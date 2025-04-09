<?php

namespace App\Repositories\Negotiation\Filter;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByMonth implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $start = Carbon::parse($value)->startOfMonth();
        $end = $start->clone()->endOfMonth();

        return $query->whereBetween('date_time', [$start->startOfWeek(), $end->endOfWeek()]);
    }
}
