<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Favorite\StoreFavoriteRequest;
use App\Models\Favorite;
use App\Services\Favorite\IFavoriteService;

class FavoriteController extends Controller
{
    public function __construct(public IFavoriteService $favoriteService)
    {
    }

    public function store(StoreFavoriteRequest $request): ResponseData
    {
        $data = $request->validated();
        $tempFavorite = Favorite::make($data);

        $model = $this->favoriteService->validateModel($tempFavorite);
        if (!$model) {
            return $this->httpNotFound([],trans('message.no_content'));
        }

        $this->favoriteService->createFavorite($tempFavorite);

        return $this->httpNoContent();
    }
}
