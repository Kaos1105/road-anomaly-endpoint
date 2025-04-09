<?php

namespace App\Trait;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait HasFavorite
{
    /**
     * @param string $model
     * @return Builder
     */
    public function getCountFavoriteQuery(string $model): Builder
    {
        $tableName = app($model)->getTable();
        $column = $tableName . '.id';

        return DB::table('common_favorites')
            ->selectRaw('count(common_favorites.id) as count_favorites')
            ->whereColumn('common_favorites.favorable_id', '=', $column)
            ->where('common_favorites.favorable_type', '=', $tableName)
            ->where('common_favorites.employee_id', '=', \Auth::user()->employee_id);
    }
}
