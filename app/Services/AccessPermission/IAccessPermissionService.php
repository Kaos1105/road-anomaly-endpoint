<?php

namespace App\Services\AccessPermission;

use App\Models\Employee;
use App\Models\System;
use App\Repositories\AccessPermission\IAccessPermissionRepository;
use Illuminate\Support\Collection;

interface IAccessPermissionService
{
    public function getRepo(): IAccessPermissionRepository;

    public function getEmployeePermissions(Employee $employee): Collection;

    public function updateAccessPermission(Collection $permissions): int;

    public function checkAccessPermission(Collection $permissions, Collection $checkPermissions): Collection;

    public function syncAccessPermission(Employee $employee): Collection;

}
