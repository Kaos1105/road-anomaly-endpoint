<?php

namespace App\Repositories\Company\Filter;

use App\Enums\Company\IndependentEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCompanyGroupName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if($value == IndependentEnum::INDEPENDENT) {
            return $query->whereNull('organization_companies.group_name');
        }else {
            return $query->where('organization_companies.group_name', $value);
        }
    }
}
