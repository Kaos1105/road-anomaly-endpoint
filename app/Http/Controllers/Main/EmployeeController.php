<?php

namespace App\Http\Controllers\Main;

use App\Enums\System\SystemCodeEnum;
use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Services\Employee\IEmployeeService;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly IEmployeeService $employeeService,
    )
    {
    }

    public function groupDropdownEmployee(): ResponseData
    {
        $employees = $this->employeeService->getSystemAccessibleEmployees(SystemCodeEnum::MAIN, true);

        return $this->httpOk(EmployeeNameResource::collection($employees));
    }
}
