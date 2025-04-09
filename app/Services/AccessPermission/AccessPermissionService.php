<?php

namespace App\Services\AccessPermission;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Http\DTO\AccessPermission\CheckCreatePermission1Data;
use App\Http\DTO\AccessPermission\CheckPermission1Data;
use App\Http\DTO\AccessPermission\SharedCheckPermission1Data;
use App\Http\Resources\AccessPermission\CheckPermissionItemResource;
use App\Http\Resources\AccessPermission\EmployeePermissionItemResource;
use App\Models\AccessPermission;
use App\Models\Employee;
use App\Models\System;
use App\Repositories\AccessPermission\IAccessPermissionRepository;
use App\Repositories\Employee\IEmployeeRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AccessPermissionService implements IAccessPermissionService
{
    public function __construct(
        public IAccessPermissionRepository $accessPermissionRepository,
        public IEmployeeRepository         $employeeRepository,
    )
    {
    }

    public function getRepo(): IAccessPermissionRepository
    {
        return $this->accessPermissionRepository;
    }

    public function updateAccessPermission(Collection $permissions): int
    {
        return AccessPermission::upsert($permissions->toArray(),
            uniqueBy: ['id']);
    }

    private function createCheckPermissionResource(SharedCheckPermission1Data|null $checkingPermission, AccessPermission $permission): CheckPermissionItemResource
    {
        $now = Carbon::now()->startOfDay();

        if ($checkingPermission) {
            $permission->permission_1 = $checkingPermission->permission_1;
            $permission->start_date = $checkingPermission->startDate;
            $permission->end_date = $checkingPermission->endDate;
        }
        $isInAccessible = !$checkingPermission || $checkingPermission->permission_1 === Permission1FlagEnum::UN_AUTHORIZED_USER || (
                $checkingPermission->startDate && Carbon::parse($checkingPermission->startDate)->gt($now)) ||
            $checkingPermission->endDate && Carbon::parse($checkingPermission->endDate)->lt($now);

        return CheckPermissionItemResource::make($permission)->setParams(!$isInAccessible);
    }

    public function checkAccessPermission(Collection $permissions, Collection $checkPermissions): Collection
    {
        $resources = collect();
        $permissions->each(function (AccessPermission $permission) use ($resources, $checkPermissions) {
            /**
             * @var $checkingPermission CheckPermission1Data
             */
            $checkingPermission = $checkPermissions->first(function (CheckPermission1Data $data) use ($permission) {
                return $data->id === $permission->id;
            });
            $resource = $this->createCheckPermissionResource($checkingPermission, $permission);

            $resources->push($resource);
        });

        return $resources->sortByDesc(function (CheckPermissionItemResource $item) {
            return $item->system->code === SystemCodeEnum::MAIN;
        })->values();
    }

    public function checkCreatAccessPermission(Collection $permissions, Collection $checkPermissions): Collection
    {
        $resources = collect();
        $permissions->each(function (CheckPermissionItemResource $permission) use ($resources, $checkPermissions) {
            /**
             * @var $checkingPermission CheckCreatePermission1Data
             */
            $checkingPermission = $checkPermissions->first(function (CheckCreatePermission1Data $data) use ($permission) {
                return $data->systemId === $permission->system_id;
            });

            $resource = $this->createCheckPermissionResource($checkingPermission, $permission->resource);

            $resources->push($resource);
        });

        return $resources->sortByDesc(function (CheckPermissionItemResource $item) {
            return $item->system->code === SystemCodeEnum::MAIN;
        })->values();
    }

    public function syncAccessPermission(Employee $employee): Collection
    {
        $employee->load('accessPermissions');
        $createdBy = \Auth::user()->employee_id;
        $now = Carbon::now()->startOfDay();

        $systems = System::query()->selectRaw(
            "CASE WHEN snet_systems.use_classification = ?
                    OR snet_systems.start_date > ? OR snet_systems.end_date < ? THEN 1 ELSE 2 END as operation_classification",
            [UseFlagEnum::NOT_USE, $now, $now]
        )->addSelect(System::$selectProps);

        $now = Carbon::now()->format(DateTimeEnum::DATE_FORMAT_V2);

        $permissionSystemIds = $employee->accessPermissions->pluck('system_id')->toArray();
        $systemIds = $systems->pluck('id')->toArray();

        $newlySystemIds = array_diff($systemIds, $permissionSystemIds);
        $nonExistedPermission = $systems->whereIn('id', $newlySystemIds);

        $resources = collect();
        $nonExistedPermission->each(function (System $system) use (
            $now, $resources, $employee, $createdBy
        ) {
            $permission = new AccessPermission([
                'employee_id' => $employee->id,
                'system_id' => $system->id,
                'permission_1' => $system->code == SystemCodeEnum::MAIN ? Permission1FlagEnum::SYSTEM_USER : Permission1FlagEnum::UN_AUTHORIZED_USER,
                'permission_2' => $system->default_permission_2,
                'permission_3' => $system->default_permission_3,
                'permission_4' => $system->default_permission_4,
                'start_date' => $system->code == SystemCodeEnum::MAIN ? $now : null,
                'created_by' => $createdBy,
                'updated_by' => $createdBy,
            ]);
            $permission->system()->associate($system);
            $isInAccessible = $permission->permission_1 === Permission1FlagEnum::UN_AUTHORIZED_USER || (
                    $permission->start_date && Carbon::parse($permission->start_date)->gt($now)) ||
                $permission->end_date && Carbon::parse($permission->end_date)->lt($now);

            $resources->push(CheckPermissionItemResource::make($permission)->setParams(!$isInAccessible));
        });

        return $resources;
    }

    public function getEmployeePermissions(Employee $employee): Collection
    {
        $permissions = $this->getRepo()->getEmployeeAccessPermission($employee);

        $resources = EmployeePermissionItemResource::collection($permissions)->collection;

        /**
         * @var $sortedCollection Collection
         */
        $sortedCollection = $resources->sortByDesc(function (EmployeePermissionItemResource $item) {
            return $item->system->code === SystemCodeEnum::MAIN;
        })->values();

        return $sortedCollection;
    }
}
