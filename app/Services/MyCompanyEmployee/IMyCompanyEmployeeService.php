<?php

namespace App\Services\MyCompanyEmployee;

use App\Models\ManagementDepartment;
use App\Models\MyCompanyEmployee;
use App\Repositories\MyCompanyEmployee\IMyCompanyEmployeeRepository;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface IMyCompanyEmployeeService
{
    public function getRepo(): IMyCompanyEmployeeRepository;

    public function getChildNames(MyCompanyEmployee $myCompanyEmployee): ?string;

    public function deleteRecord(MyCompanyEmployee $myCompanyEmployee): void;

    public function createRecord(ManagementDepartment $managementDepartment, array $dataInsert): MyCompanyEmployee|null;

    public function findByQuery(QueryBuilder $query): Collection|array;
}
