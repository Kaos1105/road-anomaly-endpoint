<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Department\DepartmentDropdownResource;
use App\Query\Department\DepartmentDropdownQuery;
use App\Services\Department\IDepartmentService;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly IDepartmentService $departmentService,
    )
    {
    }

    public function dropdownDepartments(DepartmentDropdownQuery $query): ResponseData
    {
        $departments = $this->departmentService->findByQuery($query);
        return $this->httpOk(DepartmentDropdownResource::collection($departments));
    }
}
