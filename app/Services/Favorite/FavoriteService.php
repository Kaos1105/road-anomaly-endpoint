<?php

namespace App\Services\Favorite;

use App\Enums\Common\FavoriteTypeEnum;
use App\Models\Company;
use App\Models\Department;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Favorite;
use App\Models\Site;
use App\Repositories\Favorite\IFavoriteRepository;
use Illuminate\Database\Eloquent\Model;

class FavoriteService implements IFavoriteService
{
    public function __construct(
        public IFavoriteRepository $favoriteRepository,
    )
    {
    }

    public function getRepo(): IFavoriteRepository
    {
        return $this->favoriteRepository;
    }

    public function validateModel(Favorite $favorite): ?Model
    {
        return match ($favorite->favorable_type) {
            FavoriteTypeEnum::EMPLOYEE => Employee::query()->find($favorite->favorable_id),
            FavoriteTypeEnum::COMPANY => Company::query()->find($favorite->favorable_id),
            FavoriteTypeEnum::SITE => Site::query()->find($favorite->favorable_id),
            FavoriteTypeEnum::DEPARTMENT => Department::query()->find($favorite->favorable_id),
            FavoriteTypeEnum::DIVISION => Division::query()->find($favorite->favorable_id),
            default => null,
        };
    }

    public function createFavorite(Favorite $favorite): void
    {
        $result = $this->favoriteRepository->checkExistedFavorite($favorite);
        if ($result) {
            $this->favoriteRepository->delete($result->id);
        } else
        {
            $this->favoriteRepository->create($favorite->toArray());
        }
    }
}
