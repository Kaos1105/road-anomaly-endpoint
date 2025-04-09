<?php

namespace App\Repositories\Company\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCompanyName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function ($subQuery) use ($value) {
            $subQuery->where('organization_companies.long_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_companies.kana', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_companies.previous_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_companies.code', 'LIKE', '%' . $value . '%');
        });
    }
}
