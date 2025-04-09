<?php

namespace App\Services\ContractCondition;

use App\Repositories\ContractCondition\IContractConditionRepository;

interface IContractConditionService
{
    public function getRepo(): IContractConditionRepository;

}
