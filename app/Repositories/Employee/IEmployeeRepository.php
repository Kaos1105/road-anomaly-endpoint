<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Models\System;
use App\Query\Employee\EmployeeSupplierQuery;
use App\Query\Employee\EmployeeSystemPermissionQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IEmployeeRepository extends RepositoryInterface
{
    public function getEmployeePermission(EmployeeSystemPermissionQuery $query): Collection|array;

    public function getDetail(Employee $employee): Employee;

    public function showUserDetail(Employee $detail): Employee;

    public function getAccessedEmployee(System $system): Collection;

    public function getUserEmployees(): Collection;

    public function findByQuery(QueryBuilder $query): Collection;

    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function showDetail(Employee $employee): Model|QueryBuilder;

    public function createEmployee(array $attributes): Model|Employee|null;

    public function findEmployeeSocial(): Collection;

    public function findSupplierPerson(EmployeeSupplierQuery $query): Collection;

    public function selectEmployeeSocialCustomer(): LengthAwarePaginator;

    public function dropdownCompanySelectEmployee(): Collection;

    public function checkRelations(Employee $employee): Model|Employee;

    public function getSocialResponsibleEmployee(): Collection;

}
