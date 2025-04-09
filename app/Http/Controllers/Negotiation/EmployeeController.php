<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Query\Employee\ClientSiteEmployeeDropdownQuery;
use App\Query\Employee\MyCompanyEmployeeDropdownQuery;
use App\Services\Employee\IEmployeeService;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly IEmployeeService $employeeService,
    )
    {
    }

    public function dropdownMyCompanyEmployee(MyCompanyEmployeeDropdownQuery $query): ResponseData
    {
        $employees = $this->employeeService->dropdownMyCompanyEmployee($query);
        return $this->httpOk(EmployeeNameResource::collection($employees));
    }

    public function dropdownClientSiteEmployee(ClientSiteEmployeeDropdownQuery $query): ResponseData
    {
        $employees = $this->employeeService->dropdownClientSiteEmployee($query);
        return $this->httpOk(EmployeeNameResource::collection($employees));
    }
}
