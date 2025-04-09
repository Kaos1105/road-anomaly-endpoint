<?php

namespace App\Repositories\ClientEmployee\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByClientSiteId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where('client_site_id', $value);
    }
}
