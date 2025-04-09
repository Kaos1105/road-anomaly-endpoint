<?php

namespace App\Repositories\System\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCode implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            return $query->whereIn('code', $value);
        }
        return $query->where('code', $value);
    }
}
