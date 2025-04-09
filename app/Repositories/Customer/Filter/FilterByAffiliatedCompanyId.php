<?php

namespace App\Repositories\Customer\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class FilterByAffiliatedCompanyId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (EloquentBuilder $subQuery) use ($value) {
            return $subQuery->whereHas('displayTransfer.company', function (EloquentBuilder $companyQuery) use ($value) {
                $companyQuery->where('id', $value);
            });
        });
    }
}
