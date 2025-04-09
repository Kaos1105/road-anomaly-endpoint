<?php

namespace App\Repositories\Content\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByScreenCode implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('display', function ($screenQuery) use ($value) {
            if (is_array($value)) {
                $screenQuery->whereIn('code', $value);
            } else {
                $screenQuery->where('code', $value);
            }
        });
    }
}
