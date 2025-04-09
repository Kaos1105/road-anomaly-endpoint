<?php

namespace App\Repositories\SocialData\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBySupplierId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('product', function (EloquentBuilder $productQuery) use ($value) {
            $productQuery->where('social_products.supplier_id', $value);
        });
    }
}
