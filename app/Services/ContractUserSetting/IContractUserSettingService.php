<?php

namespace App\Services\ContractUserSetting;

use App\Repositories\ContractUserSetting\IContractUserSettingRepository;

interface IContractUserSettingService
{
    public function getRepo(): IContractUserSettingRepository;

}
