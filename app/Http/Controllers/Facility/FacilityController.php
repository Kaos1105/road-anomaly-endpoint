<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Facility\UpsertFacilityRequest;
use App\Http\Resources\Facility\FacilityDetailResource;
use App\Http\Resources\Facility\FacilityItemResource;
use App\Models\Facility;
use App\Models\FacilityGroup;
use App\Services\Facility\IFacilityService;

class FacilityController extends Controller
{
    public function __construct(
        private readonly IFacilityService $facilityService,
    )
    {
    }

    public function index(FacilityGroup $group): ResponseData
    {
        $result = $this->facilityService->getRepo()->findAll($group);
        return $this->httpOk(FacilityItemResource::collection($result));
    }

    public function store(UpsertFacilityRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->facilityService->createRecord($data);
        return $this->httpCreated(new FacilityDetailResource($result));
    }

    public function show(Facility $facility): ResponseData
    {
        $result = $this->facilityService->getRepo()->getDetail($facility);
        return $this->httpOk(new FacilityDetailResource($result));
    }

    public function update(UpsertFacilityRequest $request, Facility $facility): ResponseData
    {
        $data = $request->validated();
        $facility = $this->facilityService->getRepo()->update($data, $facility->id);
        $result = $this->facilityService->getRepo()->getDetail($facility);
        return $this->httpOk(new FacilityDetailResource($result));
    }

    public function destroy(Facility $facility): ResponseData
    {
        $childNames = $this->facilityService->getChildNames($facility);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->facilityService->deleteRecord($facility);
        return $this->httpNoContent();
    }
}
