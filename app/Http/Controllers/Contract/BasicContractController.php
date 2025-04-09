<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Contract\ApproveBasicContractRequest;
use App\Http\Requests\Contract\UpsertBasicContractRequest;
use App\Http\Resources\BasicContract\BasicContractCollection;
use App\Http\Resources\BasicContract\BasicContractDetailResource;
use App\Models\BasicContract;
use App\Services\BasicContract\IBasicContractService;

class BasicContractController extends Controller
{
    public function __construct(
        private readonly IBasicContractService $basicContractService,
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->basicContractService->getRepo()->getPaginateList();
        return $this->httpOk(new BasicContractCollection($result));
    }

    public function store(UpsertBasicContractRequest $request): ResponseData
    {
        $data = $request->validated();
        $basicContract = $this->basicContractService->getRepo()->create($data);
        $basicContract = $this->basicContractService->getRepo()->showDetail($basicContract);
        return $this->httpOk(new BasicContractDetailResource($basicContract));
    }

    public function show(BasicContract $basicContract): ResponseData
    {
        $basicContract = $this->basicContractService->getRepo()->showDetail($basicContract);
        return $this->httpOk(new BasicContractDetailResource($basicContract));
    }

    public function update(BasicContract $basicContract, UpsertBasicContractRequest $request): ResponseData
    {
        $data = $request->validated();
        $basicContract = $this->basicContractService->getRepo()->update($data, $basicContract->id);
        $basicContract = $this->basicContractService->getRepo()->showDetail($basicContract);
        return $this->httpOk(new BasicContractDetailResource($basicContract));
    }

    public function destroy(BasicContract $basicContract): ResponseData
    {
        $childNames = $this->basicContractService->getChildNames($basicContract);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->basicContractService->deleteRecord($basicContract);
        return $this->httpNoContent();
    }

    public function updateApprovalFlg(BasicContract $basicContract, ApproveBasicContractRequest $request): ResponseData
    {
        $data = $request->validated();
        $updatedContract = $this->basicContractService->getRepo()->update($data, $basicContract->id);
        $basicContract = $this->basicContractService->getRepo()->showDetail($updatedContract);
        return $this->httpOk(new BasicContractDetailResource($basicContract));
    }

    public function downloadPDF(): ResponseData
    {
        return $this->httpNoContent();
    }

    public function downloadExcel(): ResponseData
    {
        return $this->httpNoContent();
    }

    public function uploadExcel(): ResponseData
    {
        return $this->httpNoContent();
    }

    public function batchRegistration(): ResponseData
    {
        return $this->httpNoContent();
    }

}
