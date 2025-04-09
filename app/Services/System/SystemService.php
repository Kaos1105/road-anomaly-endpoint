<?php

namespace App\Services\System;

use App\Enums\Common\UseFlagEnum;
use App\Models\System;
use App\Repositories\AccessPermission\IAccessPermissionRepository;
use App\Repositories\Employee\IEmployeeRepository;
use App\Repositories\System\ISystemRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class SystemService implements ISystemService
{
    public function __construct(
        public ISystemRepository           $systemRepository,
        public IEmployeeRepository         $employeeRepository,
        public IAccessPermissionRepository $accessPermissionRepository,
    )
    {
    }

    public function getRepo(): ISystemRepository
    {
        return $this->systemRepository;
    }

    public function getChildNames(System $system): ?string
    {
        $countRelation = $this->systemRepository->checkRelations($system);
        if ($countRelation->displays_count > 0) {
            return __('attributes.display.table');
        }
        return null;
    }

    public function checkSystemStopped(System $system): bool
    {
        return $system->use_classification == UseFlagEnum::NOT_USE ||
            ($system->start_date && Carbon::parse($system->start_date)->greaterThan(Carbon::now()))
            || ($system->end_date && Carbon::parse($system->end_date)->lessThan(Carbon::now()));
    }

    /**
     * @throws Throwable
     */
    public function createSystem(array $data): ?System
    {
        $system = null;

        $employees = $this->employeeRepository->getUserEmployees();

        DB::transaction(function () use ($data, &$system, $employees) {
            $system = $this->getRepo()->create($data);
            $this->accessPermissionRepository->createAccessPermission($system, $employees);
        });

        return $system;
    }

    public function exportData(): EloquentCollection
    {
        return $this->systemRepository->getDataExport();
    }

  
}
