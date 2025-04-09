<?php

namespace App\Repositories\AccessPermission;

use App\Models\Employee;
use App\Models\System;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IAccessPermissionRepository extends RepositoryInterface
{
    public function createAccessPermission(System $system, Collection $employees): int;

    public function getPaginateList(): LengthAwarePaginator;

    public function getEmployeeAccessPermission(Employee $employee): Collection;

    public function getSystemAccessiblePermission(string $systemCode, bool $checkIsActive = false): Collection;
}
