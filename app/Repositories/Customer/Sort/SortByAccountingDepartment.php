<?php

namespace App\Repositories\Customer\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByAccountingDepartment implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->join("organization_departments", "social_customers.accounting_department_id", "=", "organization_departments.id")
            ->orderByRaw("organization_departments.long_name {$direction}")
            ->orderBy("social_customers.display_order")
            ->orderByDesc("social_customers.updated_at");
    }
}
