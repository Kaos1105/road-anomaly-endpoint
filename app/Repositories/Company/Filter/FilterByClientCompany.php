<?php

namespace App\Repositories\Company\Filter;

use App\Enums\Company\CompanyClassificationEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByClientCompany implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value) {
            return $query->where('organization_companies.company_classification', '<>', CompanyClassificationEnum::SHINNICHIRO);
        }
        return $query;
    }
}
