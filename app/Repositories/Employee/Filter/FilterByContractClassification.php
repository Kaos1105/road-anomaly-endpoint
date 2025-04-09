<?php

namespace App\Repositories\Employee\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByContractClassification implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where('organization_transfers.contract_classification', $value);
    }
}
