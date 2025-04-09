<?php

namespace App\Repositories\AccessHistory\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByAction implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if(!is_array($value)) {
            return $query->where('snet_access_histories.action', $value);
        }else {
            return $query->whereIn('snet_access_histories.action', $value);
        }
    }
}
