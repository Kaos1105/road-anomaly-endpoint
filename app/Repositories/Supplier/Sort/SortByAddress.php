<?php

namespace App\Repositories\Supplier\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByAddress implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->leftJoin('organization_sites', 'social_suppliers.sales_store_id', '=', 'organization_sites.id')
            ->leftJoin('organization_companies', 'organization_sites.company_id', '=', 'organization_companies.id')
            ->orderByRaw("organization_sites.post_code {$direction}")
            ->orderBy("organization_companies.display_order")
            ->orderBy("social_suppliers.display_order")
            ->orderByDesc("social_suppliers.updated_at");
    }
}
