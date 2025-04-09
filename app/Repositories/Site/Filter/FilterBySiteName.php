<?php

namespace App\Repositories\Site\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBySiteName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function ($subQuery) use ($value) {
            $subQuery->where('organization_sites.long_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_sites.kana', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_sites.code', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_sites.address_1', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_sites.address_2', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_sites.address_3', 'LIKE', '%' . $value . '%');
        });
    }
}
