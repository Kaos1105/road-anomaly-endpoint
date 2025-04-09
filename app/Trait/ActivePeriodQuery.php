<?php

namespace App\Trait;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait ActivePeriodQuery
{
    public static function activePeriodConditions(Builder $subQuery, string $tableName): Builder
    {
        $today = Carbon::now()->startOfDay();
        return $subQuery->where(function (Builder $query) use ($today, $tableName) {
            $query->where($tableName . '.start_date', '<=', $today)
                ->where($tableName . '.end_date', '>=', $today);
        })
            ->orWhere(function (Builder $query) use ($today, $tableName) {
                $query->whereNull($tableName . '.start_date')
                    ->where($tableName . '.end_date', '>=', $today);
            })
            ->orWhere(function (Builder $query) use ($today, $tableName) {
                $query->where($tableName . '.start_date', '<=', $today)
                    ->whereNull($tableName . '.end_date');
            });
    }
}
