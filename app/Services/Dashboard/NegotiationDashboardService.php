<?php

namespace App\Services\Dashboard;

use App\Http\DTO\AccessHistory\AccessHistoryCardData;
use App\Repositories\ClientSite\IClientSiteRepository;
use App\Repositories\ManagementDepartment\IManagementDepartmentRepository;

use Illuminate\Support\Collection;

readonly class NegotiationDashboardService implements INegotiationDashboardService
{
    public function __construct(
        private IManagementDepartmentRepository $managementDepartmentRepository,
        private IClientSiteRepository           $clientSiteRepository,
    )
    {

    }

    public function checkBtnClientSite(Collection $clientSiteAccessHistory): AccessHistoryCardData
    {
        $employeeId = \Auth::user()->employee_id;
        $numberOfCustomers = $this->managementDepartmentRepository->numberOfRecordByEmployeeId($employeeId);

        return new AccessHistoryCardData($numberOfCustomers > 0, $clientSiteAccessHistory);
    }

    public function checkBtnNegotiationHistory(Collection $negotiationAccessHistory): AccessHistoryCardData
    {
        $employeeId = \Auth::user()->employee_id;
        $managementDepartments = $this->managementDepartmentRepository->findAllByEmployeeId($employeeId);
        $numberOfClientSites = $managementDepartments->count() > 0 ? $this->clientSiteRepository->countClientSitesByManagementDepartments($managementDepartments->pluck('id')->toArray()) : 0;

        return new AccessHistoryCardData($numberOfClientSites > 0, $negotiationAccessHistory);
    }

}
