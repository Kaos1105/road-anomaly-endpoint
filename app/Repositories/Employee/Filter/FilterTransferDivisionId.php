<?php

namespace App\Repositories\Employee\Filter;

use App\Repositories\AccessPermission\AccessPermissionRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterTransferDivisionId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $now = Carbon::now();
        return $query->whereHas('transfers', function (Builder $query) use ($value, $now) {
            AccessPermissionRepository::filterTransferByDateConditions($query, $now);
            $query->where('division_id', $value);
        });
    }
}
