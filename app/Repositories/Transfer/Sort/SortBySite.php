<?php

namespace App\Repositories\Transfer\Sort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySite implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? SortDirection::DESCENDING : SortDirection::ASCENDING;
        $query->leftJoin('organization_sites', 'organization_transfers.site_id', '=', 'organization_sites.id')
            ->orderByRaw("organization_sites.display_order {$direction}")
            ->orderBy("organization_transfers.start_date")
            ->orderBy("organization_transfers.display_order")
            ->orderByDesc("organization_transfers.updated_at");
    }
}
