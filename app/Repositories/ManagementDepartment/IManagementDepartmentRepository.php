<?php

namespace App\Repositories\ManagementDepartment;

use App\Models\ManagementDepartment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IManagementDepartmentRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function findAllByEmployeeId(int $employeeId): Collection|array;

    public function numberOfRecordByEmployeeId(int $employeeId): int;

    public function getDetail(ManagementDepartment $managementDepartment): Model|QueryBuilder;

    public function checkRelations(ManagementDepartment $managementDepartment): Model|ManagementDepartment;
}
