<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Company\CompanyDropdownResource;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Employee\EmployeeRelatedResource;
use App\Http\Resources\Employee\EmployeeSelectCollection;
use App\Http\Resources\Transfer\TransferItemByEmployeeResource;
use App\Models\Employee;
use App\Query\Employee\EmployeeSupplierQuery;
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

    public function dropdownEmployee(): ResponseData
    {
        $employees = $this->employeeService->getRepo()->findEmployeeSocial();
        return $this->httpOk(EmployeeNameResource::collection($employees));
    }

    public function getSupplierPerson(EmployeeSupplierQuery $query): ResponseData
    {
        $employees = $this->employeeService->findSupplierPerson($query);

        return $this->httpOk(EmployeeNameResource::collection($employees));
    }

    public function getSelectEmployees(): ResponseData
    {
        $employee = $this->employeeService->getRepo()->selectEmployeeSocialCustomer();
        return $this->httpOk(new EmployeeSelectCollection($employee));
    }

    public function dropdownCompanySelectEmployees(): ResponseData
    {
        $employee = $this->employeeService->getRepo()->dropdownCompanySelectEmployee();
        return $this->httpOk(CompanyDropdownResource::collection($employee));
    }

    public function getTransferByEmployee(Employee $employee): ResponseData
    {
        $employee = $this->transferService->getRepo()->getTransfersByEmployeeSocial($employee);
        return $this->httpOk(TransferItemByEmployeeResource::collection($employee));
    }

    public function dropdownResponsibleEmployee(): ResponseData
    {
        $employee = $this->employeeService->getRepo()->getSocialResponsibleEmployee();

        return $this->httpOk(EmployeeRelatedResource::collection($employee));
    }
}
