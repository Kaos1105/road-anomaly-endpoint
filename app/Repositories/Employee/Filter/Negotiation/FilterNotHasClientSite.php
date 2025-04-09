<?php

namespace App\Repositories\Employee\Filter\Negotiation;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterNotHasClientSite implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereDoesntHave('clientEmployees', function (Builder $subQuery) use ($value) {
            $subQuery->where('client_site_id', '=', $value);
        });
    }
}
