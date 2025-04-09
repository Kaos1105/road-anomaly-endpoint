<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\DTO\Negotiation\MyCompanyEmployeeDetailData;
use App\Http\DTO\QueryParam\MyCompanyEmployeeDropdownParam;
use App\Http\DTO\ResponseData;
use App\Http\Requests\MyCompanyEmployee\UpsertMyCompanyEmployeeRequest;
use App\Http\Resources\ManagementDepartment\MyCompanyEmployee\ManagementDepartmentEmployeeItemResource;
use App\Http\Resources\ManagementDepartment\MyCompanyEmployee\MyCompanyEmployeeDetailResource;
use App\Http\Resources\ManagementDepartment\MyCompanyEmployee\MyCompanyEmployeeDropdownResource;
use App\Models\ManagementDepartment;
use App\Models\MyCompanyEmployee;
use App\Query\Negotiation\MyCompanyEmployeeDropdownQuery;
use App\Services\MyCompanyEmployee\IMyCompanyEmployeeService;

class MyCompanyEmployeeController extends Controller
{
    public function __construct(
        private readonly IMyCompanyEmployeeService $myCompanyEmployeeService,
    )
    {
    }

    public function index(ManagementDepartment $managementDepartment): ResponseData
    {
        $result = $this->myCompanyEmployeeService->getRepo()->findAll($managementDepartment);
        return $this->httpOk(ManagementDepartmentEmployeeItemResource::collection($result));
    }

    public function store(UpsertMyCompanyEmployeeRequest $request, ManagementDepartment $managementDepartment): ResponseData
    {
        $data = $request->validated();
        $result = $this->myCompanyEmployeeService->createRecord($managementDepartment, $data);
        return $this->httpCreated(new MyCompanyEmployeeDetailResource($result));
    }

    public function show(ManagementDepartment $managementDepartment, MyCompanyEmployee $employee): ResponseData
    {
        return $this->httpOk(MyCompanyEmployeeDetailData::fromModel($employee, $managementDepartment));
    }

    public function update(UpsertMyCompanyEmployeeRequest $request, ManagementDepartment $managementDepartment, MyCompanyEmployee $employee): ResponseData
    {
        $data = $request->validated();
        $result = $this->myCompanyEmployeeService->getRepo()->update($data, $employee->id);
        return $this->httpOk(MyCompanyEmployeeDetailData::fromModel($result, $managementDepartment));
    }

    public function destroy(ManagementDepartment $managementDepartment, MyCompanyEmployee $employee): ResponseData
    {
        $childNames = $this->myCompanyEmployeeService->getChildNames($employee);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }

        $this->myCompanyEmployeeService->getRepo()->delete($employee->id);
        return $this->httpNoContent();
    }

    public function dropdownMyCompanyEmployee(MyCompanyEmployeeDropdownQuery $query): ResponseData
    {
        $result = $this->myCompanyEmployeeService->findByQuery($query->setFilterParam(new MyCompanyEmployeeDropdownParam()));

        return $this->httpOk(MyCompanyEmployeeDropdownResource::collection($result));
    }

}
