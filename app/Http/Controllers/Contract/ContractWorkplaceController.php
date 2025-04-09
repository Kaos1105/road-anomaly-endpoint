<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;

use App\Http\DTO\ResponseData;
use App\Http\Requests\Contract\UpsertContractWorkplaceRequest;
use App\Http\Resources\ContractWorkplace\ContractWorkplaceItemResource;
use App\Models\BasicContract;
use App\Models\ContractWorkplace;
use App\Services\ContractWorkplace\IContractWorkplaceService;

class ContractWorkplaceController extends Controller
{
    public function __construct(
        private readonly IContractWorkplaceService $contractWorkplaceService,
    )
    {
    }

    public function index(BasicContract $basicContract): ResponseData
    {
        $result = $this->contractWorkplaceService->getRepo()->findAll($basicContract);
        return $this->httpOk(ContractWorkplaceItemResource::collection($result));
    }

    public function store(BasicContract $basicContract, UpsertContractWorkplaceRequest $request): ResponseData
    {
        $data = $request->validated();
        $workplace = $this->contractWorkplaceService->createRecord($basicContract, $data);
        return $this->httpOk(new ContractWorkplaceItemResource($workplace));
    }

    public function update(BasicContract $basicContract, ContractWorkplace $workplace, UpsertContractWorkplaceRequest $request): ResponseData
    {
        $this->contractWorkplaceService->checkIncorrectWorkplace($basicContract, $workplace);

        $data = $request->validated();
        $workplace = $this->contractWorkplaceService->updateRecord($workplace, $data);
        return $this->httpOk(new ContractWorkplaceItemResource($workplace));
    }

    public function destroy(BasicContract $basicContract, ContractWorkplace $workplace): ResponseData
    {
        $this->contractWorkplaceService->deleteRecord($basicContract, $workplace);

        return $this->httpNoContent();
    }

}
