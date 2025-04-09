<?php

namespace App\Repositories\AccessPermission\Filter;

use App\Enums\AccessPermission\DepartmentIdFilterEnum;
use App\Repositories\AccessPermission\AccessPermissionRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByDepartmentId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $now = Carbon::now();
        return $query->whereHas('employee', function (Builder $employeeQuery) use ($now, $value) {
            $employeeQuery->whereHas('transfers', function (Builder $transferQuery) use ($now, $value) {
                AccessPermissionRepository::filterTransferByDateConditions($transferQuery, $now)
                    ->orderByDesc('organization_transfers.id')->limit(1);
                self::filterDepartment($value, $transferQuery);
            });
        });
    }

    public static function filterDepartment(?string $value, Builder $transferQuery): Builder
    {
        if ($value == DepartmentIdFilterEnum::INDEPENDENT) {
            $transferQuery->whereNull('organization_transfers.department_id');
        } else if ($value != DepartmentIdFilterEnum::DEFAULT) {
            $transferQuery->where('organization_transfers.department_id', $value);
        }
        return $transferQuery;
    }
}
