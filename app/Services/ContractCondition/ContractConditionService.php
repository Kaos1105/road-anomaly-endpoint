<?php

namespace App\Services\ContractCondition;

use App\Repositories\ContractCondition\IContractConditionRepository;

readonly class ContractConditionService implements IContractConditionService
{
    public function __construct(
        private IContractConditionRepository $contractConditionRepository,
    )
    {
    }

    public function getRepo(): IContractConditionRepository
    {
        return $this->contractConditionRepository;
    }

}
