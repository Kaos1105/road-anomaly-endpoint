<?php

namespace App\Services\Employee;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Enums\System\SystemCodeEnum;
use App\Helpers\FileHelper;
use App\Helpers\SystemHelper;
use App\Http\DTO\QueryParam\EmployeeDropdownNegotiationParam;
use App\Models\AccessPermission;
use App\Models\Employee;
use App\Query\Employee\ClientSiteEmployeeDropdownQuery;
use App\Query\Employee\EmployeeSupplierQuery;
use App\Query\Employee\MyCompanyEmployeeDropdownQuery;
use App\Repositories\AccessPermission\IAccessPermissionRepository;
use App\Repositories\Employee\IEmployeeRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class EmployeeService implements IEmployeeService
{
    public function __construct(
        public IEmployeeRepository         $employeeRepository,
        public IAccessPermissionRepository $accessPermissionRepository,
    )
    {
    }

    public function getRepo(): IEmployeeRepository
    {
        return $this->employeeRepository;
    }

    public function getChildNames(Employee $employee): ?string
    {
        $countRelation = $this->employeeRepository->checkRelations($employee);

        if ($countRelation->transfers_count > 0) {
            return __('attributes.transfer.table');
        }


        if (
            $countRelation->customer_count > 0 ||
            $countRelation->customer_responsive_count > 0 ||

            $countRelation->management_group_preparatory_personnel_count > 0 ||
            $countRelation->management_group_applicant_count > 0 ||
            $countRelation->management_group_approver_count > 0 ||
            $countRelation->management_group_final_decision_maker_count > 0 ||
            $countRelation->management_group_ordering_personnel_count > 0 ||
            $countRelation->management_group_payment_personnel_count > 0 ||
            $countRelation->management_group_completion_personnel_count > 0 ||

            $countRelation->supplier_person_count > 0 ||
            $countRelation->supplier_company_person_count > 0

        ) {
            return SystemHelper::getSystemName(SystemCodeEnum::SOCIAL);
        }

        if (
            $countRelation->client_employees_count > 0 || $countRelation->management_department_employees_count > 0
        ) {
            return SystemHelper::getSystemName(SystemCodeEnum::NEGOTIATION);
        }


        if (
            $countRelation->counterparty_contractor_count > 0 ||
            $countRelation->counterparty_representative_count > 0 ||
            $countRelation->contractor_count > 0 ||
            $countRelation->representative_count > 0
        ) {
            return SystemHelper::getSystemName(SystemCodeEnum::CONTRACT);
        }

        return null;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Employee $employee): void
    {
        DB::transaction(function () use ($employee) {
            if (count($employee->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($employee->attachmentFiles, AccessibleTypeEnum::EMPLOYEE);
            }
            $employee->favorites()->delete();
            $employee->delete();
        });
    }

    public function findByUnit(): Collection
    {
        if (empty(request('filter'))) {
            return collect();
        }
        return $this->employeeRepository->findAll();
    }

    public function findSupplierPerson(EmployeeSupplierQuery $query): Collection
    {
        $filter = request('filter');
        if (!$filter || empty($filter['store_site_id'])) {
            return collect();
        }
        return $this->getRepo()->findSupplierPerson($query);
    }

    public function dropdownMyCompanyEmployee(MyCompanyEmployeeDropdownQuery $query): Collection
    {
        $filter = request('filter');
        if (!$filter) {
            return collect();
        }
        $query->setFilterParam(new EmployeeDropdownNegotiationParam(companyClassification: CompanyClassificationEnum::SHINNICHIRO));

        return $this->getRepo()->findByQuery($query);
    }

    public function dropdownClientSiteEmployee(ClientSiteEmployeeDropdownQuery $query): Collection
    {
        $filter = request('filter');
        if (!$filter) {
            return collect();
        }

        return $this->getRepo()->findByQuery($query);
    }

    public function getSystemAccessibleEmployees(string $systemCode, bool $checkIsActive = false): Collection
    {
        $accessPermissions = $this->accessPermissionRepository->getSystemAccessiblePermission($systemCode, $checkIsActive);
        $employeeIds = $accessPermissions->map(fn(AccessPermission $permission) => $permission->employee_id)->unique()->values();

        return Employee::whereIn('id', $employeeIds)->get(Employee::$selectProps);
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        if (empty(request('filter'))) {
            return collect();
        }
        return $this->employeeRepository->findByQuery($query);
    }
}
