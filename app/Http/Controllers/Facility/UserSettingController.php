<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\FacilityUserSetting\UpsertFacilityUserSettingRequest;
use App\Http\Resources\FacilityUserSetting\FacilityUserSettingResource;

use App\Services\FacilityUserSetting\IFacilityUserSettingService;

class UserSettingController extends Controller
{
    public function __construct(
        private readonly IFacilityUserSettingService $facilityUserSettingService,
    )
    {
    }

    public function store(UpsertFacilityUserSettingRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->facilityUserSettingService->createRecord($data);
        return $this->httpCreated(new FacilityUserSettingResource($result));
    }

    public function show(): ResponseData
    {
        $result = $this->facilityUserSettingService->showUserSetting();
        return $this->httpOk(new FacilityUserSettingResource($result));
    }

}
