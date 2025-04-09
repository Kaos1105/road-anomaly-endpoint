<?php

namespace App\Repositories\Display\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByScreenCode implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            return $query->whereIn('code', $value);
        }
        return $query->where('code', $value);

    }
}
