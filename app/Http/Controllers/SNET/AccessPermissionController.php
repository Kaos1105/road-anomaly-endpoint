<?php

namespace App\Http\Controllers\SNET;

use App\Enums\System\SystemCodeEnum;
use App\Http\Controllers\Controller;
use App\Http\DTO\AccessPermission\CheckCreatePermission1Data;
use App\Http\DTO\AccessPermission\CheckPermission1Data;
use App\Http\DTO\AccessPermission\CreatePermission1Data;
use App\Http\DTO\AccessPermission\UpdatePermission1Data;
use App\Http\DTO\AccessPermission\UpdatePermissionData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\AccessPermission\CheckCreatePermissionRequest;
use App\Http\Requests\AccessPermission\CheckPermissionRequest;
use App\Http\Requests\AccessPermission\UpsertPermission1Request;
use App\Http\Requests\AccessPermission\UpsertPermissionRequest;
use App\Http\Resources\AccessPermission\CheckPermissionItemResource;
use App\Http\Resources\AccessPermission\PermissionCollection;
use App\Models\Employee;
use App\Services\AccessPermission\IAccessPermissionService;
use App\Services\Auth\IAuthService;
use Illuminate\Support\Collection;

class AccessPermissionController extends Controller
{
    public function __construct(private readonly IAccessPermissionService $accessPermissionService, private readonly IAuthService $authService)
    {
    }

    public function updatePermissions(UpsertPermissionRequest $request): ResponseData
    {
        $data = $request->validated();
        $permissions = collect(UpdatePermissionData::collect($data['access_permissions']));
        $this->accessPermissionService->updateAccessPermission($permissions);
        $this->authService->clearEmployeePermission($permissions);

        return $this->httpOk();
    }

    public function index(): ResponseData
    {

        $permissions = $this->accessPermissionService->getRepo()->getPaginateList();

        return $this->httpOk(new PermissionCollection($permissions));
    }

    public function getCreatingEmployeePermission(Employee $employee): ResponseData
    {

        $resources = $this->accessPermissionService->syncAccessPermission($employee);
        /**
         * @var $sortedCollection Collection
         */
        $sortedCollection = $resources->sortByDesc(function (CheckPermissionItemResource $item) {
            return $item->system->code === SystemCodeEnum::MAIN;
        })->values();

        return $this->httpOk($sortedCollection->toArray());
    }

    public function getEmployeeAccessPermission(Employee $employee): ResponseData
    {
        $sortedCollection = $this->accessPermissionService->getEmployeePermissions($employee);

        return $this->httpOk($sortedCollection->toArray());
    }

    public function getUserPermission(Employee $employee): ResponseData
    {
        $sortedCollection = $this->accessPermissionService->getEmployeePermissions($employee);

        return $this->httpOk($sortedCollection->toArray());
    }

    public function checkEmployeeAccessPermission(Employee $employee, CheckPermissionRequest $request): ResponseData
    {
        $data = $request->validated();
        $checkingPermissions = collect(CheckPermission1Data::collect($data['access_permissions']));
        $permissions = $this->accessPermissionService->getRepo()->getEmployeeAccessPermission($employee);

        $checkedPermissions = $this->accessPermissionService->checkAccessPermission($permissions, $checkingPermissions);

        return $this->httpOk($checkedPermissions->toArray());
    }

    public function checkCreatingEmployeeAccessPermission(Employee $employee, CheckCreatePermissionRequest $request): ResponseData
    {
        $data = $request->validated();
        $checkingPermissions = collect(CheckCreatePermission1Data::collect($data['access_permissions']));
        $permissions = $this->accessPermissionService->syncAccessPermission($employee);

        $checkedPermissions = $this->accessPermissionService->checkCreatAccessPermission($permissions, $checkingPermissions);

        return $this->httpOk($checkedPermissions->toArray());
    }

    public function createUserPermission(UpsertPermission1Request $request, Employee $employee): ResponseData
    {
        $data = $request->validated();
        $permissions = collect(CreatePermission1Data::collect($data['access_permissions']));
        $this->accessPermissionService->updateAccessPermission($permissions);

        return $this->httpCreated();
    }

    public function updateUserPermission(UpsertPermission1Request $request, Employee $employee): ResponseData
    {
        $data = $request->validated();
        $permissions = collect(UpdatePermission1Data::collect($data['access_permissions']));
        $this->accessPermissionService->updateAccessPermission($permissions);
        $this->authService->clearUserToken($permissions);

        return $this->httpNoContent();
    }
}
