<?php

namespace App\Services\DeviceInformation;

use App\Enums\Common\UseFlagEnum;

use App\Models\DeviceInformation;
use App\Repositories\DeviceInformation\IDeviceInformationRepository;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Auth;

readonly class DeviceInformationService implements IDeviceInformationService
{
    public function __construct(
        private IDeviceInformationRepository $deviceInformationRepository,
    )
    {
    }

    public function getRepo(): IDeviceInformationRepository
    {
        return $this->deviceInformationRepository;
    }

    public function findAllByAuth(): Collection
    {
        $employeeId = Auth::user()->employee_id;
        return $this->deviceInformationRepository->findAll($employeeId);
    }

    public function findAllUsingByAuth(): Collection
    {
        $employeeId = Auth::user()->employee_id;
        $request = request();
        $request->merge(['filter' => ['use_classification' => UseFlagEnum::USE]]);
        return $this->deviceInformationRepository->findAll($employeeId);
    }

    public function getDetail(DeviceInformation $device): DeviceInformation|null
    {
        if (Auth::user()->employee_id != $device->employee_id) {
            return null;
        }
        return $device->load(['createdBy', 'updatedBy']);
    }

    public function updateData(array $dataUpdate, DeviceInformation $device): DeviceInformation|null
    {
        if ($dataUpdate['employee_id'] != $device->employee_id) {
            return null;
        }
        return $this->updateInfo($dataUpdate, $device);
    }

    public function updateNotUse(DeviceInformation $device): DeviceInformation|null
    {
        if ($device->employee_id != Auth::user()->employee_id) {
            return null;
        }
        return $this->updateInfo(['use_classification' => UseFlagEnum::NOT_USE], $device);
    }

    private function updateInfo(array $dataUpdate, DeviceInformation $device): DeviceInformation|null
    {
        $updatedDevice = $this->deviceInformationRepository->update($dataUpdate, $device->id);
        return $updatedDevice?->load(['createdBy', 'updatedBy']);
    }

    public function getTokenByDeviceName(): DeviceInformation|null
    {
        $deviceName = request('name');
        if (!$deviceName) {
            return $deviceName;
        }
        $device = $this->deviceInformationRepository->findByDeviceName(Auth::user()->employee_id, $deviceName);
        return $device?->load(['createdBy', 'updatedBy']);
    }

    public function updateTokenByDeviceName(array $dataUpdate): DeviceInformation|null
    {
        $device = $this->deviceInformationRepository->findByDeviceName(Auth::user()->employee_id, $dataUpdate['name']);
        if (!$device) {
            return $device;
        }
        return $this->updateInfo(['device_token' => $dataUpdate['device_token']], $device);
    }
}

