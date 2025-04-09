<?php

namespace App\Repositories\SocialData\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCustomerResponsible implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('customer', function (EloquentBuilder $customerQuery) use ($value) {
            $customerQuery->where('social_customers.responsible_id', $value);
        });
    }
}
