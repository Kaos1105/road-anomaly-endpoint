<?php

namespace App\Repositories\Employee\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBySystemId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $systemIds = [$value];
        return $query->whereHas('accessPermissions', function (Builder $accessPermissionsQuery) use ($systemIds) {
            FilterBySystemCode::querySystemPermission($systemIds, $accessPermissionsQuery);
        });
    }
}
