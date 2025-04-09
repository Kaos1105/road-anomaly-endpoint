<?php

namespace App\Repositories\Favorite;

use App\Models\Favorite;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IFavoriteRepository extends RepositoryInterface
{
    public function checkExistedFavorite(Favorite $favorite): Favorite|null;

}
