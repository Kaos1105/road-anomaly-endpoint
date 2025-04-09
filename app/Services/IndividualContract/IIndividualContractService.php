<?php

namespace App\Services\IndividualContract;

use App\Models\IndividualContract;
use App\Repositories\IndividualContract\IIndividualContractRepository;

interface IIndividualContractService
{
    public function getRepo(): IIndividualContractRepository;

    public function deleteRecord(IndividualContract $individualContract): void;

}
