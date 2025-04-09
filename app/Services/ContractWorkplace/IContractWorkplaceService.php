<?php

namespace App\Services\ContractWorkplace;

use App\Http\DTO\ResponseData;
use App\Models\BasicContract;
use App\Models\ContractWorkplace;
use App\Repositories\ContractWorkplace\IContractWorkplaceRepository;

interface IContractWorkplaceService
{
    public function getRepo(): IContractWorkplaceRepository;

    public function createRecord(BasicContract $basicContract, array $dataInsert): ContractWorkplace;

    public function checkIncorrectWorkplace(BasicContract $basicContract, ContractWorkplace $contractWorkplace): void;

    public function updateRecord(ContractWorkplace $contractWorkplace, array $dataUpdate): ContractWorkplace;

    public function deleteRecord(BasicContract $basicContract, ContractWorkplace $contractWorkplace): void;

}
