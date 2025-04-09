<?php

namespace App\Services\FacilityUserSetting;

use App\Models\FacilityUserSetting;
use App\Repositories\FacilityUserSetting\IFacilityUserSettingRepository;
use Illuminate\Pagination\LengthAwarePaginator;

interface IFacilityUserSettingService
{
    public function getRepo(): IFacilityUserSettingRepository;

    public function createRecord(array $dataInsert): FacilityUserSetting;

    public function getPaginateList(): LengthAwarePaginator;

    public function showUserSetting(): FacilityUserSetting|null;
}
