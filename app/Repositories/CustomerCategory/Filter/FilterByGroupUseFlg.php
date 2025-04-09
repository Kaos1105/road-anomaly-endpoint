<?php

namespace App\Repositories\CustomerCategory\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByGroupUseFlg implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('managementGroup', function (EloquentBuilder $managementQuery) use ($value) {
            $managementQuery->where('social_management_groups.use_classification', $value);
        });
    }
}
