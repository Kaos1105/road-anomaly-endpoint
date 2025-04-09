<?php

namespace App\Repositories\BasicContract\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCodeName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (Builder $query) use ($value) {
            $query->where('contract_basic_contracts.code', 'LIKE', '%' . $value . '%')
                ->orWhere('contract_basic_contracts.name', 'LIKE', '%' . $value . '%');
        });
    }
}
