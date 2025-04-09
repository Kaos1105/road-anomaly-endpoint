<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\DTO\QueryParam\DepartmentDropdownNegotiationParam;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Department\DepartmentShortNameDropdownResource;
use App\Query\Department\DepartmentDropdownNegotiationQuery;
use App\Services\Department\IDepartmentService;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly IDepartmentService $departmentService,
    )
    {
    }

    public function dropdownDepartment(DepartmentDropdownNegotiationQuery $query): ResponseData
    {
        $departments = $this->departmentService->findByQuery($query->setFilterParam(new DepartmentDropdownNegotiationParam()));
        return $this->httpOk(DepartmentShortNameDropdownResource::collection($departments));
    }

}
