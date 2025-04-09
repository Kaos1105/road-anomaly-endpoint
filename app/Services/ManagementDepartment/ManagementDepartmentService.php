<?php

namespace App\Services\ManagementDepartment;

use App\Models\ManagementDepartment;
use App\Repositories\ManagementDepartment\IManagementDepartmentRepository;
use Illuminate\Database\Eloquent\Collection;

readonly class ManagementDepartmentService implements IManagementDepartmentService
{
    public function __construct(
        private IManagementDepartmentRepository $managementDepartmentRepository,
    )
    {
    }

    public function getRepo(): IManagementDepartmentRepository
    {
        return $this->managementDepartmentRepository;
    }

    public function getChildNames(ManagementDepartment $managementDepartment): ?string
    {
        $countRelation = $this->managementDepartmentRepository->checkRelations($managementDepartment);
        if ($countRelation->my_company_employees_count > 0) {
            return __('attributes.my_company_employee.table');
        }
        return null;
    }

    public function allManagementDepartmentsByAuth(): Collection
    {
        $employeeId = \Auth::user()->employee_id;
        return $this->getRepo()->findAllByEmployeeId($employeeId);
    }

}
