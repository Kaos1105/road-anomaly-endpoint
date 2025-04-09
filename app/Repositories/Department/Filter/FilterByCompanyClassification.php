<?php

namespace App\Repositories\Department\Filter;

use App\Enums\Common\UseFlagEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCompanyClassification implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('site', function (EloquentBuilder $managementQuery) use ($value) {
            $managementQuery->where('use_classification', UseFlagEnum::USE)
                ->whereHas('company', function (EloquentBuilder $companyQuery) use ($value) {
                    $companyQuery->where('use_classification', UseFlagEnum::USE)
                        ->where('company_classification', $value );
                });
        });
    }
}
