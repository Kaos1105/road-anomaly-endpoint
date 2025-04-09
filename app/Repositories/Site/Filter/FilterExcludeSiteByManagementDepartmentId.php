<?php

namespace App\Repositories\Site\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterExcludeSiteByManagementDepartmentId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value) {
            $query->whereDoesntHave('clientSite', function (Builder $query) use ($value) {
                $query->where('management_department_id', $value);
            });
        }
    }
}
