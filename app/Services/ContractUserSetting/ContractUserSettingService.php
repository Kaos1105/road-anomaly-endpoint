<?php

namespace App\Services\ContractUserSetting;

use App\Repositories\ContractUserSetting\IContractUserSettingRepository;

readonly class ContractUserSettingService implements IContractUserSettingService
{
    public function __construct(
        private IContractUserSettingRepository $contractUserSettingRepository,
    )
    {
    }

    public function getRepo(): IContractUserSettingRepository
    {
        return $this->contractUserSettingRepository;
    }

}
