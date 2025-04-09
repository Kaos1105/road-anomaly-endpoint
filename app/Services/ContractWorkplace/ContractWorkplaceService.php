<?php

namespace App\Services\ContractWorkplace;

use App\Http\DTO\ResponseData;
use App\Models\BasicContract;
use App\Models\ContractWorkplace;
use App\Repositories\ContractWorkplace\IContractWorkplaceRepository;
use Symfony\Component\HttpFoundation\Response;

readonly class ContractWorkplaceService implements IContractWorkplaceService
{
    public function __construct(
        private IContractWorkplaceRepository $contractWorkplaceRepository,
    )
    {
    }

    public function getRepo(): IContractWorkplaceRepository
    {
        return $this->contractWorkplaceRepository;
    }

    public function createRecord(BasicContract $basicContract, array $dataInsert): ContractWorkplace
    {
        $workplace = $this->contractWorkplaceRepository->create([
            'basic_contract_id' => $basicContract->id,
            ...$dataInsert
        ]);
        return $workplace->load(['division', 'createdBy', 'updatedBy']);
    }

    public function checkIncorrectWorkplace(BasicContract $basicContract, ContractWorkplace $contractWorkplace): void
    {
        if ($contractWorkplace->basic_contract_id != $basicContract->id) {
            abort(Response::HTTP_NOT_FOUND);
        }
    }

    public function updateRecord(ContractWorkplace $contractWorkplace, array $dataUpdate): ContractWorkplace
    {
        $workplace = $this->contractWorkplaceRepository->update($dataUpdate, $contractWorkplace->id);
        return $workplace->load(['division', 'createdBy', 'updatedBy']);
    }


    public function deleteRecord(BasicContract $basicContract, ContractWorkplace $contractWorkplace): void
    {
        $this->checkIncorrectWorkplace($basicContract, $contractWorkplace);

        $contractWorkplace->delete();
    }

}
