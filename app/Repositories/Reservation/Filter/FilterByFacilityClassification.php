<?php

namespace App\Repositories\Reservation\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByFacilityClassification implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('facility', function (Builder $subQuery) use ($value) {
            $subQuery->where('facility_classification', $value);
        });
    }
}
