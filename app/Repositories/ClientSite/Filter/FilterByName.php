<?php

namespace App\Repositories\ClientSite\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (Builder $query) use ($value) {
            $query->where('organization_companies.short_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_companies.long_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_sites.short_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_sites.long_name', 'LIKE', '%' . $value . '%');
        });
    }
}
