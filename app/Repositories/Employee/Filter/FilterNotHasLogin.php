<?php

namespace App\Repositories\Employee\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterNotHasLogin implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->doesntHave('logins');
    }
}
