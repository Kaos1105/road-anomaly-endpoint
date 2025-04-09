<?php

namespace App\Repositories\Product\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByProductName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (Builder $query) use ($value) {
            $query->where('social_products.name', 'LIKE', '%' . $value . '%')
                ->orWhere('social_products.code', 'LIKE', '%' . $value . '%');
        });
    }
}
