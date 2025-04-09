<?php

namespace App\Http\Controllers\SNET;

use App\Enums\Common\UseFlagEnum;
use App\Http\Controllers\Controller;
use App\Http\DTO\QueryParam\EmployeeDropdownParam;
use App\Http\DTO\QueryParam\UserDropdownParam;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Employee\EmployeePermissionResource;
use App\Http\Resources\Employee\EmployeeUserResource;
use App\Models\Employee;
use App\Query\Employee\EmployeeDropdownQuery;
use App\Query\Employee\EmployeeSystemPermissionQuery;
use App\Query\Employee\UserDropdownQuery;
use App\Services\Employee\IEmployeeService;

class EmployeeController extends Controller
{
    public function __construct(private readonly IEmployeeService $employeeService)
    {
    }

    public function show(Employee $employee): ResponseData
    {

        $result = $this->employeeService->getRepo()->showUserDetail($employee);

        return $this->httpOk(new EmployeeUserResource($result));
    }

    public function getAccessibleEmployee(EmployeeSystemPermissionQuery $query): ResponseData
    {
        $result = $this->employeeService->getRepo()->getEmployeePermission($query);

        return $this->httpOk(EmployeePermissionResource::collection($result));
    }

    public function dropdownEmployee(EmployeeDropdownQuery $query): ResponseData
    {
        $systems = $this->employeeService->getRepo()->findByQuery($query->setFilterParam(new EmployeeDropdownParam(true)));

        return $this->httpOk(EmployeeNameResource::collection($systems));
    }

    public function dropdownTransferEmployee(EmployeeDropdownQuery $query): ResponseData
    {
        $systems = $this->employeeService->getRepo()->findByQuery($query->
        setFilterParam(new EmployeeDropdownParam(
            hasAccessPermission: null, useClassification: UseFlagEnum::USE, notHasLogin: true)));

        return $this->httpOk(EmployeeNameResource::collection($systems));
    }

    public function dropdownUsers(UserDropdownQuery $query): ResponseData
    {
        $systems = $this->employeeService->getRepo()->findByQuery($query->setFilterParam(new UserDropdownParam(true)));
        return $this->httpOk(EmployeeNameResource::collection($systems));
    }

}
