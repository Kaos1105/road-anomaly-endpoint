<?php

namespace App\Repositories\Negotiation\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByClientSiteIds implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereIn('client_site_id', $value);
    }
}
