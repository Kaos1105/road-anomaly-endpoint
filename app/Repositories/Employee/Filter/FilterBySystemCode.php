<?php

namespace App\Repositories\Employee\Filter;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Models\System;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterBySystemCode implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $systemIds = System::query()->where('code', $value)->pluck('id')->toArray();
        return $query->whereHas('accessPermissions', function (Builder $accessPermissionsQuery) use ($systemIds) {
            self::querySystemPermission($systemIds, $accessPermissionsQuery);
        });
    }

    public static function querySystemPermission(array $systemIds, Builder $query): Builder
    {
        return $query->whereIn('system_id', $systemIds)
            ->where('permission_1', '!=', Permission1FlagEnum::UN_AUTHORIZED_USER);
    }
}
