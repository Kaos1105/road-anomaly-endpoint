<?php

namespace App\Services\DeviceInformation;

use App\Models\DeviceInformation;
use App\Repositories\DeviceInformation\IDeviceInformationRepository;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface IDeviceInformationService
{
    public function getRepo(): IDeviceInformationRepository;

    public function findAllByAuth(): Collection;

    public function findAllUsingByAuth(): Collection;

    public function getDetail(DeviceInformation $device): DeviceInformation|null;

    public function updateData(array $dataUpdate, DeviceInformation $device): DeviceInformation|null;

    public function updateNotUse(DeviceInformation $device): DeviceInformation|null;

    public function getTokenByDeviceName(): DeviceInformation|null;

    public function updateTokenByDeviceName(array $dataUpdate): DeviceInformation|null;

}
