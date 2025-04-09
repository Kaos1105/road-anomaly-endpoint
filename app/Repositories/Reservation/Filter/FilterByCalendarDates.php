<?php

namespace App\Repositories\Reservation\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCalendarDates implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('reservations', function (Builder $subQuery) use ($value) {
            $subQuery->whereIn('reservation_date', $value);
        });
    }
}
