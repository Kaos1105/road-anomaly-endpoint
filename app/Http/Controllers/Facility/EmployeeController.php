<?php

namespace App\Http\Controllers\Facility;

use App\Enums\Company\IndependentEnum;
use App\Enums\System\SystemCodeEnum;
use App\Http\Controllers\Controller;
use App\Http\DTO\QueryParam\UsePersonFacilityDropdownParam;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Query\Employee\UsePersonFacilityDropdownQuery;
use App\Services\Employee\IEmployeeService;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly IEmployeeService $employeeService,
    )
    {
    }

    public function dropdownEmployee(): ResponseData
    {
        $employees = $this->employeeService->getSystemAccessibleEmployees(SystemCodeEnum::FACILITY, true);
        return $this->httpOk(EmployeeNameResource::collection($employees));
    }

    public function dropdownUsePerson(UsePersonFacilityDropdownQuery $query): ResponseData
    {
        $employees = $this->employeeService->getRepo()->findByQuery($query->setFilterParam(
            new UsePersonFacilityDropdownParam(request('filter')['facility_group_id'] ?? IndependentEnum::INDEPENDENT_NUMBER))
        );
        return $this->httpOk(EmployeeNameResource::collection($employees));
    }

}
