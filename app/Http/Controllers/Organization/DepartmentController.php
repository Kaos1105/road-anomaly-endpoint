<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Department\RepresentDivisionRequest;
use App\Http\Requests\Department\UpsertDepartmentRequest;
use App\Http\Resources\Department\DepartmentDetailResource;
use App\Http\Resources\Department\DepartmentDropdownResource;
use App\Http\Resources\Department\DivisionItemByDepartmentResource;
use App\Http\Resources\Department\ShinnichiroDepartmentItemResource;
use App\Models\Department;
use App\Query\Department\DepartmentDropdownQuery;
use App\Services\Department\IDepartmentService;
use App\Services\Division\IDivisionService;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly IDepartmentService $departmentService,
        private readonly IDivisionService   $divisionService
    )
    {
    }

    public function store(UpsertDepartmentRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->departmentService->getRepo()->create($data);

        return $this->httpCreated(new DepartmentDetailResource($result));
    }

    public function show(Department $department): ResponseData
    {
        $result = $this->departmentService->getRepo()->getDetail($department);
        return $this->httpOk(new DepartmentDetailResource($result));
    }

    public function update(UpsertDepartmentRequest $request, Department $department): ResponseData
    {
        $data = $request->validated();
        $result = $this->departmentService->getRepo()->update($data, $department->id);

        return $this->httpCreated(new DepartmentDetailResource($result));
    }

    public function destroy(Department $department): ResponseData
    {
        $childNames = $this->departmentService->getChildNames($department);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->departmentService->deleteRecord($department);

        return $this->httpNoContent();
    }

    public function getDivisions(Department $department): ResponseData
    {
        $divisions = $this->divisionService->getRepo()->getListDivisionsByDepartment($department);

        return $this->httpOk(DivisionItemByDepartmentResource::collection($divisions));
    }

    public function dropdownDepartments(DepartmentDropdownQuery $query): ResponseData
    {
        $departments = $this->departmentService->findByQuery($query);
        return $this->httpOk(DepartmentDropdownResource::collection($departments));
    }

    public function organizationDropdownDepartments(DepartmentDropdownQuery $query): ResponseData
    {
        $departments = $this->departmentService->findByQuery($query, true);
        return $this->httpOk(DepartmentDropdownResource::collection($departments));
    }

    public function setRepresentative(Department $department, RepresentDivisionRequest $request): ResponseData
    {
        $representDivisionId = $request->input('division_id');
        $dataUpdate = $request->only(['updated_at', 'updated_by']);
        $this->divisionService->getRepo()->setRepresentativeDivision($department, $representDivisionId, $dataUpdate);

        return $this->httpNoContent();

    }

    public function getShinnichiroDepartments(): ResponseData
    {
        $departments = $this->departmentService->getShinichiroDepartments();

        return $this->httpOk(ShinnichiroDepartmentItemResource::collection($departments));

    }
}
