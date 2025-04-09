<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Http\DTO\QueryParam\FacilityGroupDropdownParam;
use App\Http\DTO\ResponseData;
use App\Http\Requests\FacilityGroup\UpsertFacilityGroupRequest;
use App\Http\Resources\FacilityGroup\FacilityGroupCollection;
use App\Http\Resources\FacilityGroup\FacilityGroupDetailResource;
use App\Http\Resources\FacilityGroup\FacilityGroupDropdownResource;
use App\Models\FacilityGroup;
use App\Query\Facility\FacilityGroupDropdownQuery;
use App\Services\FacilityGroup\IFacilityGroupService;

class FacilityGroupController extends Controller
{
    public function __construct(
        private readonly IFacilityGroupService $facilityGroupService,
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->facilityGroupService->getRepo()->getPaginateList();
        return $this->httpOk(new FacilityGroupCollection($result));
    }

    public function dropdownFacilityGroup(FacilityGroupDropdownQuery $query): ResponseData
    {
        $result = $this->facilityGroupService->findByQuery($query->setFilterParam(new FacilityGroupDropdownParam()));
        return $this->httpOk(FacilityGroupDropdownResource::collection($result));
    }

    public function store(UpsertFacilityGroupRequest $request): ResponseData
    {
        $data = $request->validated();
        $facilityGroup = $this->facilityGroupService->createRecord($data);
        return $this->httpCreated(new FacilityGroupDetailResource($facilityGroup));
    }

    public function show(FacilityGroup $group): ResponseData
    {
        $result = $this->facilityGroupService->getRepo()->getDetail($group);
        return $this->httpOk(new FacilityGroupDetailResource($result));
    }

    public function update(UpsertFacilityGroupRequest $request, FacilityGroup $group): ResponseData
    {
        $data = $request->validated();
        $facilityGroup = $this->facilityGroupService->getRepo()->update($data, $group->id);
        $result = $this->facilityGroupService->getRepo()->getDetail($facilityGroup);
        return $this->httpOk(new FacilityGroupDetailResource($result));
    }

    public function destroy(FacilityGroup $group): ResponseData
    {
        $childNames = $this->facilityGroupService->getChildNames($group);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->facilityGroupService->getRepo()->delete($group->id);
        return $this->httpNoContent();
    }

    public function dropdownFacilityGroupUserSetting(): ResponseData
    {
        $result = $this->facilityGroupService->getRepo()->dropdownFacilityGroupUserSetting();
        return $this->httpOk(FacilityGroupDropdownResource::collection($result));
    }

}
