<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\DeviceInformation\UpdateDeviceTokenRequest;
use App\Http\Requests\DeviceInformation\UpsertDeviceRequest;
use App\Http\Resources\DeviceInformation\DeviceDetailResource;
use App\Http\Resources\DeviceInformation\DeviceItemResource;
use App\Models\DeviceInformation;
use App\Services\DeviceInformation\IDeviceInformationService;

class DeviceInformationController extends Controller
{
    public function __construct(
        private readonly IDeviceInformationService $deviceInformationService,
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->deviceInformationService->findAllByAuth();
        return $this->httpOk(DeviceItemResource::collection($result));
    }

    public function store(UpsertDeviceRequest $request): ResponseData
    {
        $data = $request->validated();

        $result = $this->deviceInformationService->getRepo()->create($data);
        $device = $this->deviceInformationService->getDetail($result);
        return $this->httpCreated(new DeviceDetailResource($device));
    }

    public function show(DeviceInformation $device): ResponseData
    {
        $device = $this->deviceInformationService->getDetail($device);
        if ($device) {
            return $this->httpOk(new DeviceDetailResource($device));
        }
        return $this->httpNotFound([], trans('errors.page_not_found'));
    }

    public function update(UpsertDeviceRequest $request, DeviceInformation $device): ResponseData
    {
        $data = $request->validated();
        $result = $this->deviceInformationService->updateData($data, $device);
        if ($result) {
            return $this->httpOk(new DeviceDetailResource($result));
        }
        return $this->httpNotFound([], trans('errors.page_not_found'));
    }

    public function changeNotUse(DeviceInformation $device): ResponseData
    {
        $result = $this->deviceInformationService->updateNotUse($device);
        if ($result) {
            return $this->httpOk(new DeviceDetailResource($result));
        }
        return $this->httpNotFound([], trans('errors.page_not_found'));
    }

    public function getToken(): ResponseData
    {
        $result = $this->deviceInformationService->getTokenByDeviceName();
        if ($result) {
            return $this->httpOk(new DeviceDetailResource($result));
        }
        return $this->httpOk();
    }

    public function updateToken(UpdateDeviceTokenRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->deviceInformationService->updateTokenByDeviceName($data);
        if ($result) {
            return $this->httpOk(new DeviceDetailResource($result));
        }
        return $this->httpNotFound([], trans('errors.page_not_found'));
    }

    public function getListInUse(): ResponseData
    {
        $result = $this->deviceInformationService->findAllUsingByAuth();
        return $this->httpOk(DeviceItemResource::collection($result));
    }
}
