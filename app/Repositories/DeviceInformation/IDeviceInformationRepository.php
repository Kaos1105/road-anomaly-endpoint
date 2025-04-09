<?php

namespace App\Repositories\DeviceInformation;

use App\Models\DeviceInformation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IDeviceInformationRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(int $employeeId): Collection|array;

    public function findByDeviceName(int $employeeId, string $deviceName): DeviceInformation|null;

}
