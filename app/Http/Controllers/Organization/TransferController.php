<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Transfer\UpsertTransferRequest;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Transfer\TransferCopyDetailResource;
use App\Http\Resources\Transfer\TransferDetailResource;
use App\Models\Transfer;
use App\Services\Transfer\ITransferService;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function __construct(private readonly ITransferService $transferService)
    {
    }

    public function store(UpsertTransferRequest $request): ResponseData
    {
        $data = $request->validated();
        $transfer = $this->transferService->getRepo()->create($data);
        $result = $this->transferService->getRepo()->showDetail($transfer);
        return $this->httpCreated(new TransferDetailResource($result));
    }

    public function show(Transfer $transfer): ResponseData
    {
        $result = $this->transferService->getRepo()->showDetail($transfer);
        return $this->httpOk(new TransferDetailResource($result));
    }

    public function update(Transfer $transfer, UpsertTransferRequest $request): ResponseData
    {
        $data = $request->validated();
        $transfer = $this->transferService->getRepo()->update($data, $transfer->id);
        $result = $this->transferService->getRepo()->showDetail($transfer);
        return $this->httpOk(new TransferDetailResource($result));
    }

    public function copyTransfer(Transfer $transfer): ResponseData
    {
        $result = $this->transferService->getRepo()->showDetail($transfer);
        return $this->httpOk(new TransferCopyDetailResource($result));
    }

    public function destroy(Transfer $transfer): ResponseData
    {
        $childNames = $this->transferService->getChildNames($transfer);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }

        $transfer = $this->transferService->showEmployee($transfer);
        $employeeResource = EmployeeNameResource::make($transfer->employee);
        $this->transferService->getRepo()->delete($transfer->id);

        return $this->httpOk($employeeResource);
    }

    public function setRepresentative(Transfer $transfer, Request $request): ResponseData
    {
        $dataUpdate = $request->only(['updated_at', 'updated_by']);
        $this->transferService->getRepo()->setRepresentativeTransfer($transfer, $dataUpdate);

        return $this->httpNoContent();
    }
}
