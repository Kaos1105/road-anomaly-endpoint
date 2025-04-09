<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Query\Employee\ClientSiteEmployeeDropdownQuery;
use App\Query\Employee\EmployeeSupplierQuery;
use App\Query\Employee\MyCompanyEmployeeDropdownQuery;
use App\Repositories\Employee\IEmployeeRepository;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface IEmployeeService
{
    public function getRepo(): IEmployeeRepository;

    public function getChildNames(Employee $employee): ?string;

    public function deleteRecord(Employee $employee): void;

    public function findByUnit(): Collection;

    public function findSupplierPerson(EmployeeSupplierQuery $query): Collection;

    public function dropdownMyCompanyEmployee(MyCompanyEmployeeDropdownQuery $query): Collection;

    public function dropdownClientSiteEmployee(ClientSiteEmployeeDropdownQuery $query): Collection;

    public function getSystemAccessibleEmployees(string $systemCode, bool $checkIsActive = false): Collection;

    public function findByQuery(QueryBuilder $query): Collection|array;
}
