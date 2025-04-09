<?php

namespace App\Repositories\ClientSite\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterHasNegotiation implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('negotiations');
    }
}
