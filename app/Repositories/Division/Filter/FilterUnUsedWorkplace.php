<?php

namespace App\Repositories\Division\Filter;

use App\Models\ContractWorkplace;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterUnUsedWorkplace implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $divisionIds = ContractWorkplace::where('basic_contract_id', $value)->get('division_id')->pluck('division_id');

        if (!$divisionIds->isEmpty()) {
            return $query->whereNotIn('id', $divisionIds);
        }

        return $query;

    }
}
