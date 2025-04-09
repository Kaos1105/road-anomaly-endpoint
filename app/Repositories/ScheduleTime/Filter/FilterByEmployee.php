<?php

namespace App\Repositories\ScheduleTime\Filter;

use App\Enums\Schedule\PublicClassificationEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByEmployee implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if ($value) {
            $userEmployeeId = Auth::user()->employee_id;
            if ($value == $userEmployeeId) {
                $query->where('employee_id', $value);
            } else {
                $query->where('employee_id', $value)
                    ->where(function (EloquentBuilder $query) use ($userEmployeeId, $value) {
                        $query->where('public_classification', PublicClassificationEnum::ALL_MEMBER)
                            ->orWhere(function ($query) use ($userEmployeeId, $value) {
                                $query->where('public_classification', PublicClassificationEnum::PUBLIC_GROUP)
                                    ->whereHas('group', function (EloquentBuilder $groupQuery) use ($userEmployeeId, $value) {
                                        $groupQuery->whereHas('groupEmployees', function (EloquentBuilder $groupEmployeeQuery) use ($userEmployeeId, $value) {
                                            $groupEmployeeQuery->where('employee_id', $userEmployeeId);
                                        });
                                    });
                            });
                    });
            }
        }
        return $query;
    }
}
