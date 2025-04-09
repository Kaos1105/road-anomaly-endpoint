<?php

namespace App\Repositories\FacilityUserSetting;

use App\Models\FacilityUserSetting;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IFacilityUserSettingRepository extends RepositoryInterface
{
    public function getDetail(int $userId): FacilityUserSetting|null;

}

