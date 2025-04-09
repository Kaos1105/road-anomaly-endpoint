<?php

namespace App\Services\AccessHistory;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\AccessHistory\ResultRadioSummaryEnum;
use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\AuthenticationHistory\SummaryTableEnum;
use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\PaginationEnum;
use App\Enums\System\SystemCodeEnum;
use App\Http\DTO\AccessHistory\ManagementDepartmentCardData;
use App\Http\DTO\AccessHistory\SummaryGraphHourData;
use App\Http\DTO\AccessHistory\SummarySystemData;
use App\Http\DTO\AccessHistory\SummarySystemMonthData;
use App\Http\DTO\AccessHistory\SummarySystemYearData;
use App\Http\DTO\AccessHistory\SummaryUserItemData;
use App\Http\DTO\AccessHistory\SummaryUserSystemData;
use App\Http\DTO\AccessHistory\UserPermissionSettingCardData;
use App\Http\DTO\AuthenticationHistory\SummaryData;
use App\Models\AccessHistory;
use App\Models\System;
use App\Repositories\AccessHistory\IAccessHistoryRepository;
use App\Repositories\Employee\IEmployeeRepository;
use App\Repositories\System\ISystemRepository;
use App\Trait\HasPermission;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AccessHistoryService implements IAccessHistoryService
{
    use HasPermission;

    public function __construct(
        public IAccessHistoryRepository $accessHistoryRepository,
        public ISystemRepository        $systemRepository,
        public IEmployeeRepository      $employeeRepository,
    )
    {
    }

    private function getEmptyFilterActionResult(Collection $filterResult): Collection
    {
        $filter = request('filter');
        if (!$filter || empty($filter['action'])) {
            return collect();
        }
        return $filterResult;
    }

    private function getEmptyFilterSystemResult(Collection $filterResult): Collection
    {
        $filter = request('filter');
        if (!$filter || empty($filter['action'])) {
            return collect();
        }
        return $filterResult;
    }

    private function getEmptyFilterResult(Collection $filterResult): Collection
    {
        $filter = request('filter');
        if (!$filter || empty($filter['system_id']) || empty($filter['action'])) {
            return collect();
        }
        return $filterResult;
    }

    public function getRepo(): IAccessHistoryRepository
    {
        return $this->accessHistoryRepository;
    }

    public function insertAccessPermissions(Collection $permissions): int
    {
        return AccessHistory::insert($permissions->toArray());
    }

    public function getAccessHistories(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;
        return $this->getEmptyFilterResult($this->accessHistoryRepository->findAll($numberRecord));
    }

    public function getTopicAccessHistories(): Collection
    {
        $filter = request('filter');
        if (!$filter || empty($filter['system_id'])) {
            return collect();
        }
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;
        return $this->accessHistoryRepository->findTopicDashboard($numberRecord);
    }

    public function getLoginSNETDashboard(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD_5;
        $request = request();
        $filter = $request['filter'];
        if (!$filter || empty($filter['action'])) {
            //10 Portal
            $filter['action'] = AccessActionTypeEnum::LOGIN;
        } else {
            //60 S-net
            $filter['accessible_type'] = AccessibleTypeEnum::LOGIN;
        }
        $request->merge(['filter' => $filter]);
        return $this->accessHistoryRepository->findLoginSNETDashboard($numberRecord);
    }

    public function getCompanyAccessHistories(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;
        return $this->getEmptyFilterActionResult($this->accessHistoryRepository->findCompany($numberRecord));
    }

    public function getEmployeeAccessHistories(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;
        return $this->accessHistoryRepository->findEmployees($numberRecord);
    }

    public function getEmployeeShinichiroAccessHistories(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;
        return $this->accessHistoryRepository->findEmployees($numberRecord, true);
    }

    public function getSupplierSocialDashboard(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;
        return $this->getEmptyFilterActionResult($this->accessHistoryRepository->findSupplierSocialDashboard($numberRecord));
    }

    public function getCustomerSocialDashboard(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;
        return $this->getEmptyFilterActionResult($this->accessHistoryRepository->findCustomerSocialDashboard($numberRecord));
    }

    public function getProductSocialDashboard(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;
        return $this->getEmptyFilterActionResult($this->accessHistoryRepository->findProductSocialDashboard($numberRecord));
    }

    public function getUserPermissionSetting(): UserPermissionSettingCardData
    {
        $filter = request('filter');
        if ($filter && !empty($filter['system_id'])) {
            $systemId = $filter['system_id'];
            $accessPermission = $this->getPermissionBySystemId($systemId);
            if ($accessPermission && $accessPermission->permission_1 == Permission1FlagEnum::SYSTEM_MANAGER) {
                $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD_5;
                $records = $this->accessHistoryRepository->findEditUserPermissionSetting($numberRecord);

                return new UserPermissionSettingCardData(true, $records);
            }
        }
        return new UserPermissionSettingCardData(false, null);
    }

    public function getManagementDepartmentDashboard(): ManagementDepartmentCardData
    {
        $filter = request('filter');
        if ($filter && !empty($filter['action'])) {

            $accessPermission = $this->getEmployeePermission(SystemCodeEnum::NEGOTIATION);

            if ($accessPermission && $accessPermission->permission_1 == Permission1FlagEnum::SYSTEM_MANAGER) {

                $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD_5;
                $records = $this->accessHistoryRepository->findManagementDepartmentDashboard($numberRecord);

                return new ManagementDepartmentCardData(true, $records);
            }
        }
        return new ManagementDepartmentCardData(false, null);
    }

    public function getClientSiteDashboard(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD_5;
        return $this->getEmptyFilterActionResult($this->accessHistoryRepository->findClientSiteDashboard($numberRecord));
    }

    public function getNegotiationHistoryDashboard(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD_5;
        return $this->getEmptyFilterActionResult($this->accessHistoryRepository->findNegotiationHistoryDashboard($numberRecord));
    }

    public function getAnnouncementHistoryBySystem(): Collection
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD_5;
        return $this->getEmptyFilterSystemResult($this->accessHistoryRepository->findNegotiationHistoryDashboard($numberRecord));
    }

    public function getListYears(): array
    {
        $currentYear = Carbon::now()->year;
        $history = $this->accessHistoryRepository->getLastHistory();

        $firstYear = $history && $history->access_at
            ? Carbon::parse($history->access_at)->year
            : $currentYear;

        return range($firstYear, $currentYear);
    }

    private function getFilterSummary(): array|null
    {
        $filter = request('filter');
        if (!$filter || empty($filter['year']) || empty($filter['result_classification'])) {
            return null;
        }
        if (!in_array($filter['result_classification'], ResultRadioSummaryEnum::getValues())) {
            return null;
        }
        return $filter;
    }

    public function getSummarySystem(): SummaryData|null
    {
        $filter = $this->getFilterSummary();
        if (empty($filter)) {
            return null;
        }
        $years = [(int)$filter['year'], $filter['year'] - SummaryTableEnum::LAST_YEAR_KEY, $filter['year'] - SummaryTableEnum::TWO_YEAR_AGO_KEY];

        $systems = $this->systemRepository->getListSystemManagement();
        $isOkClassification = false;
        if ($filter['result_classification'] == ResultRadioSummaryEnum::OK) {
            $isOkClassification = true;
        }
        $monthData = $this->accessHistoryRepository->countSystemEachMonthByYear($filter['year'], $isOkClassification);
        $yearData = $this->accessHistoryRepository->countSystemByYears($years, $isOkClassification);

        $monthly = collect();
        foreach (DateTimeEnum::SHORT_NAME_MONTHS_OF_YEAR as $month) {
            $monthly->push(new SummarySystemMonthData($month));
        }
        $listYears = collect();
        foreach ($years as $year) {
            $listYears->push(new SummarySystemYearData($year));
        }

        $result = SummarySystemData::mapCollection($systems, $listYears, $monthly, $yearData, $monthData);

        return new SummaryData($years, $result);
    }

    public function getSummaryUser(): Collection|null
    {
        $filter = $this->getFilterSummary();
        if (empty($filter)) {
            return null;
        }
        $employees = $this->employeeRepository->getUserEmployees();

        $isOkClassification = false;
        if ($filter['result_classification'] == ResultRadioSummaryEnum::OK) {
            $isOkClassification = true;
        }

        $systems = $this->systemRepository->getListSystemManagement();
        $data = $this->accessHistoryRepository->countSystemsEmployeeId($filter['year'], $isOkClassification);

        $defaultSystems = $systems->map(function (System $system) {
            return new SummaryUserSystemData($system->code);
        });

        return SummaryUserItemData::mapCollection($defaultSystems, $employees, $systems, $data);
    }

    public function getSummaryTime(): Collection|null
    {
        $filter = $this->getFilterSummary();
        if (empty($filter)) {
            return null;
        }

        $hours = range(0, 23, 1);
        $defaultHours = collect($hours)->map(function (int $hour) {
            return new SummaryGraphHourData($hour);
        });

        $isOkClassification = false;
        if ($filter['result_classification'] == ResultRadioSummaryEnum::OK) {
            $isOkClassification = true;
        }
        $numberOfDays = $this->calculateDaysInYear($filter['year']);

        $data = $this->accessHistoryRepository->countAccessEachHour($filter['year'], $isOkClassification, $numberOfDays);

        return SummaryGraphHourData::mapCollection($defaultHours, $data);
    }

    private function calculateDaysInYear(int $year): int
    {
        if ($year == Carbon::now()->year) {
            return Carbon::now()->dayOfYear;
        }
        return Carbon::createFromDate($year)->daysInYear;
    }
}
