<?php

namespace App\Repositories\Content\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBySystemCode implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('display', function ($displayQuery) use ($value) {
            $displayQuery->whereHas('system', function ($systemQuery) use ($value) {
                if (is_array($value)) {
                    $systemQuery->whereIn('code', $value);
                } else {
                    $systemQuery->where('code', $value);
                }
            });
        });

    }
}
