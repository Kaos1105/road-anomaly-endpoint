<?php

namespace App\Services\AccessHistory;

use App\Http\DTO\AccessHistory\ManagementDepartmentCardData;
use App\Http\DTO\AccessHistory\UserPermissionSettingCardData;
use App\Http\DTO\AuthenticationHistory\SummaryData;
use App\Repositories\AccessHistory\IAccessHistoryRepository;
use Illuminate\Support\Collection;

interface IAccessHistoryService
{
    public function getRepo(): IAccessHistoryRepository;

    public function insertAccessPermissions(Collection $permissions): int;

    public function getAccessHistories(): Collection;

    public function getLoginSNETDashboard(): Collection;

    public function getCompanyAccessHistories(): Collection;

    public function getEmployeeAccessHistories(): Collection;

    public function getEmployeeShinichiroAccessHistories(): Collection;

    public function getSupplierSocialDashboard(): Collection;

    public function getCustomerSocialDashboard(): Collection;

    public function getProductSocialDashboard(): Collection;

    public function getUserPermissionSetting(): UserPermissionSettingCardData;

    public function getManagementDepartmentDashboard(): ManagementDepartmentCardData;

    public function getClientSiteDashboard(): Collection;

    public function getNegotiationHistoryDashboard(): Collection;

    public function getAnnouncementHistoryBySystem(): Collection;

    public function getListYears(): array;

    public function getSummarySystem(): SummaryData|null;

    public function getSummaryUser(): Collection|null;

    public function getSummaryTime(): Collection|null;

}
