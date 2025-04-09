<?php

namespace App\Services\Favorite;

use App\Models\Favorite;
use App\Repositories\Favorite\IFavoriteRepository;
use Illuminate\Database\Eloquent\Model;

interface IFavoriteService
{
    public function getRepo(): IFavoriteRepository;

    public function validateModel(Favorite $favorite): ?Model;

    public function createFavorite(Favorite $favorite): void;

}
