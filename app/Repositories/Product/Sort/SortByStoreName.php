<?php

namespace App\Repositories\Product\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByStoreName implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->leftJoin('social_suppliers', 'social_products.supplier_id', '=', 'social_suppliers.id')
            ->leftJoin('organization_sites', 'social_suppliers.sales_store_id', '=', 'organization_sites.id')
            ->orderByRaw("organization_sites.display_order {$direction}")
            ->orderBy("social_products.code")
            ->orderBy("social_products.display_order")
            ->orderByDesc("social_products.updated_at");
    }
}
