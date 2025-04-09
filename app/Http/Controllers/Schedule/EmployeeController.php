<?php

namespace App\Http\Controllers\Schedule;

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

    public function weeklyScheduleDropdownEmployee(): ResponseData
    {
        $employees = $this->employeeService->getSystemAccessibleEmployees(SystemCodeEnum::SCHEDULE);

        return $this->httpOk(EmployeeNameResource::collection($employees));
    }
}
