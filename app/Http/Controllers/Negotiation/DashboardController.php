<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Services\AccessHistory\IAccessHistoryService;
use App\Services\Dashboard\INegotiationDashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly INegotiationDashboardService $negotiationDashboardService,
        private readonly IAccessHistoryService        $accessHistoryService,
    )
    {
    }

    public function getManagementDepartment(): ResponseData
    {
        $history = $this->accessHistoryService->getManagementDepartmentDashboard();

        return $this->httpOk($history);
    }

    public function getClientSite(): ResponseData
    {
        $history = $this->accessHistoryService->getClientSiteDashboard();
        $result = $this->negotiationDashboardService->checkBtnClientSite($history);

        return $this->httpOk($result);
    }

    public function getNegotiationHistory(): ResponseData
    {
        $history = $this->accessHistoryService->getNegotiationHistoryDashboard();
        $result = $this->negotiationDashboardService->checkBtnNegotiationHistory($history);

        return $this->httpOk($result);
    }

}
