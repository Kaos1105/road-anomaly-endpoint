<?php

namespace App\Repositories\Product\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCompanyId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->leftJoin('social_suppliers', 'social_products.supplier_id', '=', 'social_suppliers.id')
            ->leftJoin('organization_sites', 'social_suppliers.sales_store_id', '=', 'organization_sites.id')
            ->leftJoin('organization_companies', 'organization_sites.company_id', '=', 'organization_companies.id')
            ->where('organization_companies.id', '=',  $value);
    }
}
