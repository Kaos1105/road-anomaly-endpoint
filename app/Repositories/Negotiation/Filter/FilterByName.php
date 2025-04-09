<?php

namespace App\Repositories\Negotiation\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where(function (Builder $query) use ($value) {
            $query->where(DB::raw("REGEXP_REPLACE(ExtractValue(negotiation_negotiations.manager_comment, '//text()'), '<[^>]*>', '')"), 'LIKE', '%' . $value . '%')
                ->orWhere(DB::raw("REGEXP_REPLACE(ExtractValue(negotiation_negotiations.result, '//text()'), '<[^>]*>', '')"), 'LIKE', '%' . $value . '%')
                ->orWhereHas('site', function (Builder $siteQuery) use ($value) {
                    $siteQuery->where('short_name', 'LIKE', '%' . $value . '%')
                        ->orWhere('long_name', 'LIKE', '%' . $value . '%')
                        ->orWhereHas('company', function (Builder $companyQuery) use ($value) {
                            $companyQuery->where('short_name', 'LIKE', '%' . $value . '%')
                                ->orWhere('long_name', 'LIKE', '%' . $value . '%');
                        });
                })
                ->orWhereHas('participants', function (Builder $negotiationEmployeeQuery) use ($value) {
                    $negotiationEmployeeQuery->whereHas('negotiable', function (Builder $clientEmployeeQuery) use ($value) {
                        $clientEmployeeQuery->whereHas('employee', function (Builder $employeeQuery) use ($value) {
                            $employeeQuery->where('last_name', 'LIKE', '%' . $value . '%')
                                ->orWhere('first_name', 'LIKE', '%' . $value . '%');
                        });
                    });
                });
        });
    }
}
