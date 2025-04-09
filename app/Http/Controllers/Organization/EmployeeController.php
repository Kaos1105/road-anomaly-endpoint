<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Employee\UpsertEmployeeRequest;
use App\Http\Resources\Employee\EmployeeCollection;
use App\Http\Resources\Employee\EmployeeDetailResource;
use App\Http\Resources\Employee\EmployeeItemByUnitResource;
use App\Http\Resources\Transfer\TransferItemByEmployeeResource;
use App\Models\Employee;
use App\Services\Employee\IEmployeeService;
use App\Services\Transfer\ITransferService;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly IEmployeeService $employeeService,
        private readonly ITransferService $transferService
    )
    {
    }

    public function index(): ResponseData
    {
        $employees = $this->employeeService->getRepo()->getPaginateList();
        return $this->httpOk(new EmployeeCollection($employees));
    }

    public function store(UpsertEmployeeRequest $request): ResponseData
    {
        $data = $request->validated();

        $employee = $this->employeeService->getRepo()->createEmployee($data);
        if (!$employee) {
            return $this->httpBadRequest();
        }

        return $this->httpCreated(new EmployeeDetailResource($employee->load('transfers')));
    }

    public function show(Employee $employee): ResponseData
    {
        $employee = $this->employeeService->getRepo()->showDetail($employee);
        return $this->httpOk(new EmployeeDetailResource($employee));
    }

    public function update(Employee $employee, UpsertEmployeeRequest $request): ResponseData
    {
        $data = $request->validated();
        $employee = $this->employeeService->getRepo()->update($data, $employee->id);
        return $this->httpOk(new EmployeeDetailResource($employee));
    }

    public function destroy(Employee $employee): ResponseData
    {
        $childNames = $this->employeeService->getChildNames($employee);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->employeeService->deleteRecord($employee);
        return $this->httpNoContent();
    }

    public function getTransfers(Employee $employee): ResponseData
    {
        $result = $this->transferService->getRepo()->getTransfersByEmployee($employee);

        return $this->httpOk(TransferItemByEmployeeResource::collection($result));
    }

    public function getEmployeeByUnit(): ResponseData
    {
        $result = $this->employeeService->findByUnit();

        return $this->httpOk(EmployeeItemByUnitResource::collection($result));
    }

}
