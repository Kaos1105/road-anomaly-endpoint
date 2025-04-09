<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\ManagementDepartment\UpsertManagementDepartmentRequest;
use App\Http\Resources\ManagementDepartment\ManagementDepartmentCollection;
use App\Http\Resources\ManagementDepartment\ManagementDepartmentDetailResource;
use App\Models\ManagementDepartment;
use App\Services\ManagementDepartment\IManagementDepartmentService;

class ManagementDepartmentController extends Controller
{
    public function __construct(
        private readonly IManagementDepartmentService $managementDepartmentService,
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->managementDepartmentService->getRepo()->getPaginateList();
        return $this->httpOk(new ManagementDepartmentCollection($result));
    }

    public function store(UpsertManagementDepartmentRequest $request): ResponseData
    {
        $data = $request->validated();
        $managementDepartment = $this->managementDepartmentService->getRepo()->create($data);
        $result = $this->managementDepartmentService->getRepo()->getDetail($managementDepartment);
        return $this->httpCreated(new ManagementDepartmentDetailResource($result));
    }

    public function show(ManagementDepartment $managementDepartment): ResponseData
    {
        $result = $this->managementDepartmentService->getRepo()->getDetail($managementDepartment);
        return $this->httpOk(new ManagementDepartmentDetailResource($result));
    }

    public function update(UpsertManagementDepartmentRequest $request, ManagementDepartment $managementDepartment): ResponseData
    {
        $data = $request->validated();
        $managementDepartment = $this->managementDepartmentService->getRepo()->update($data, $managementDepartment->id);
        $result = $this->managementDepartmentService->getRepo()->getDetail($managementDepartment);
        return $this->httpOk(new ManagementDepartmentDetailResource($result));
    }

    public function destroy(ManagementDepartment $managementDepartment): ResponseData
    {
        $childNames = $this->managementDepartmentService->getChildNames($managementDepartment);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->managementDepartmentService->getRepo()->delete($managementDepartment->id);
        return $this->httpNoContent();
    }
}
