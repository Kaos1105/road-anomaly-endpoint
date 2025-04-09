<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\ManagementGroup\UpsertManagementGroupRequest;
use App\Http\Resources\CustomerCategory\CustomerCategoryItemResource;
use App\Http\Resources\ManagementGroup\ManagementGroupDetailResource;
use App\Http\Resources\ManagementGroup\ManagementGroupRelatedResource;
use App\Models\ManagementGroup;
use App\Query\CustomerCategory\CustomerCategoryDropdownQuery;
use App\Query\ManagementGroup\ManagementGroupDropdownQuery;
use App\Services\ManagementGroup\IManagementGroupService;

class ManagementGroupController extends Controller
{
    public function __construct(
        private readonly IManagementGroupService $managementGroupService,
    )
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertManagementGroupRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->managementGroupService->getRepo()->createManagementGroup($data);
        return $this->httpCreated(ManagementGroupDetailResource::make($result));
    }

    public function show(ManagementGroup $managementGroup): ResponseData
    {
        $managementGroup = $this->managementGroupService->getRepo()->showDetail($managementGroup);
        return $this->httpOk(ManagementGroupDetailResource::make($managementGroup));
    }

    public function destroy(ManagementGroup $managementGroup): ResponseData
    {

        $childNames = $this->managementGroupService->getChildNames($managementGroup);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->managementGroupService->getRepo()->delete($managementGroup->id);
        return $this->httpNoContent();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertManagementGroupRequest $request, ManagementGroup $managementGroup): ResponseData
    {
        $data = $request->validated();
        $result = $this->managementGroupService->getRepo()->updateManagementGroup($data, $managementGroup);
        return $this->httpOk(ManagementGroupDetailResource::make($result));
    }

    public function dropdownManagementGroup(ManagementGroupDropdownQuery $query): ResponseData
    {
        $systems = $this->managementGroupService->getRepo()->findByQuery($query);

        return $this->httpOk(ManagementGroupRelatedResource::collection($systems));
    }

    public function dropdownCustomerCategory(CustomerCategoryDropdownQuery $query): ResponseData
    {
        $systems = $this->managementGroupService->getCustomerCategoryRepo()->findByQuery($query);

        return $this->httpOk(CustomerCategoryItemResource::collection($systems));
    }
}
