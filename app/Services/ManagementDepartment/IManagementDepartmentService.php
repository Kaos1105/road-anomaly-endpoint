<?php

namespace App\Services\ManagementDepartment;

use App\Models\ManagementDepartment;
use App\Repositories\ManagementDepartment\IManagementDepartmentRepository;
use Illuminate\Database\Eloquent\Collection;

interface IManagementDepartmentService
{
    public function getRepo(): IManagementDepartmentRepository;

    public function getChildNames(ManagementDepartment $managementDepartment): ?string;

    public function allManagementDepartmentsByAuth(): Collection;


}
