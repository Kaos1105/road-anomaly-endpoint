<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\System\UpsertSystemRequest;
use App\Http\Resources\System\SystemDetailResource;
use App\Http\Resources\System\SystemDropdownResource;
use App\Http\Resources\System\SystemItemResource;
use App\Http\Resources\System\SystemSortedDropdown;
use App\Models\System;
use App\Query\System\SystemDropdownQuery;
use App\Services\Auth\IAuthService;
use App\Services\System\ISystemService;

class SystemController extends Controller
{
    public function __construct(private readonly ISystemService $systemService,
                                private readonly IAuthService   $authService,
    )
    {
    }

    public function index(): ResponseData
    {
        $systems = $this->systemService->getRepo()->getList();

        return $this->httpOk(SystemItemResource::collection($systems));
    }

    public function dropdownSystem(SystemDropdownQuery $query): ResponseData
    {
        $systems = $this->systemService->getRepo()->findByQuery($query);

        return $this->httpOk(SystemDropdownResource::collection($systems));
    }

    public function store(UpsertSystemRequest $request): ResponseData
    {
        $data = $request->validated();
        $system = $this->systemService->createSystem($data);

        return $this->httpCreated(new SystemDetailResource($system));
    }

    public function show(System $system): ResponseData
    {
        $result = $this->systemService->getRepo()->showDetail($system);

        return $this->httpOk(new SystemDetailResource($result));
    }

    public function update(UpsertSystemRequest $request, System $system): ResponseData
    {
        $data = $request->validated();
        $system = $this->systemService->getRepo()->update($data, $system->id);

        if ($this->systemService->checkSystemStopped($system)) {
            $this->authService->clearAccessedToken($system);
        }

        return $this->httpOk(new SystemDetailResource($system));
    }

    public function destroy(System $system): ResponseData
    {
        $childNames = $this->systemService->getChildNames($system);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->authService->clearAccessedToken($system);
        $this->systemService->getRepo()->delete($system->id);

        return $this->httpOk();
    }

    public function getSystemsSorted(): ResponseData
    {
        $result = $this->systemService->getRepo()->getSystemSortedByDisplayOrder();

        return $this->httpOk(SystemSortedDropdown::collection($result));
    }
}
