<?php

namespace App\Services\BasicContract;

use App\Models\BasicContract;
use App\Repositories\BasicContract\IBasicContractRepository;

interface IBasicContractService
{
    public function getRepo(): IBasicContractRepository;

    public function getChildNames(BasicContract $basicContract): ?string;

    public function deleteRecord(BasicContract $basicContract): void;

}
