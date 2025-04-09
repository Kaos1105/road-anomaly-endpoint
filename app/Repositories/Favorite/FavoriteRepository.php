<?php

namespace App\Repositories\Favorite;

use App\Models\Favorite;
use Prettus\Repository\Eloquent\BaseRepository;


class FavoriteRepository extends BaseRepository implements IFavoriteRepository
{
    public function model(): string
    {
        return Favorite::class;
    }

    public function checkExistedFavorite(Favorite $favorite): Favorite|null
    {
        return Favorite::where([
            'favorable_type' =>  $favorite->favorable_type,
            'favorable_id' =>  $favorite->favorable_id,
            'employee_id' =>  $favorite->employee_id
        ])->first();
    }
}
