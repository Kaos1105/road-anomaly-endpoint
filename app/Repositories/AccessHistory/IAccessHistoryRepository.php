<?php

namespace App\Repositories\AccessHistory;

use App\Models\AccessHistory;
use App\Models\System;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IAccessHistoryRepository extends RepositoryInterface
{
    public function findAll(int $numberRecords): Collection;

    public function findLoginSNETDashboard(int $numberRecords): Collection;

    public function findTopicDashboard(int $numberRecords): Collection;

    public function findSupplierSocialDashboard(int $numberRecords): Collection;

    public function findCustomerSocialDashboard(int $numberRecords): Collection;

    public function findProductSocialDashboard(int $numberRecords): Collection;

    public function findEditUserPermissionSetting(int $numberRecords): Collection;

    public function findManagementDepartmentDashboard(int $numberRecords): Collection;

    public function findClientSiteDashboard(int $numberRecords): Collection;

    public function findNegotiationHistoryDashboard(int $numberRecords): Collection;

    public function findCompany(int $numberRecords): \Illuminate\Support\Collection;

    public function findEmployees(int $numberRecords, bool $isShinichiro = false): \Illuminate\Support\Collection;

    public function getPaginateList(): LengthAwarePaginator;

    public function findAccessHistoryBySystem(System $system, array $accessibleTypes, int $numberRecords): Collection;

    public function getTwoLastLoginHistory(): Collection;

    public function findAnnouncementHistoryBySystemId(int $systemId, int $numberRecords): Collection;

    public function countAccessPortalDuringLogin(int $systemId): int;

    public function getLastHistory(): QueryBuilder|AccessHistory|null;

    public function countSystemEachMonthByYear(string $year, bool $isOKClassification): Collection|null;

    public function countSystemByYears(array $years, bool $isOKClassification): Collection|null;

    public function countSystemsEmployeeId(string $year, bool $isOKClassification): Collection|null;

    public function countAccessEachHour(string $year, bool $isOKClassification, int $daysInYear): Collection|null;

}
