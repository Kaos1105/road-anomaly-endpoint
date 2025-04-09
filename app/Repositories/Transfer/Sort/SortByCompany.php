<?php

namespace App\Repositories\Transfer\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByCompany implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->join('organization_companies', 'organization_transfers.company_id', '=', 'organization_companies.id')
            ->orderByRaw("organization_companies.display_order {$direction}")
            ->orderBy("organization_transfers.start_date")
            ->orderBy("organization_transfers.display_order")
            ->orderByDesc("organization_transfers.updated_at");
    }
}
