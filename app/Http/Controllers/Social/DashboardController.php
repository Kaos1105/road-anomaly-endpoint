<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\AccessHistory\AccessHistoryCardData;
use App\Http\DTO\ResponseData;
use App\Http\Resources\EventClassification\EventClassificationDashboardResource;
use App\Http\Resources\ManagementGroup\ManagementGroupDashboardResource;
use App\Http\Resources\SocialData\TopFiveYearDashboardResource;
use App\Services\AccessHistory\IAccessHistoryService;
use App\Services\Dashboard\ISocialDashboardService;
use App\Services\EventClassification\IEventClassificationService;
use App\Services\ManagementGroup\IManagementGroupService;
use App\Services\SocialData\ISocialDataService;
use App\Services\SocialEvent\ISocialEventService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly ISocialDashboardService     $socialDashboardService,
        private readonly ISocialEventService         $socialEventService,
        private readonly IManagementGroupService     $managementGroupService,
        private readonly IEventClassificationService $eventClassificationService,
        private readonly IAccessHistoryService       $accessHistoryService,
        private readonly ISocialDataService          $socialDataService
    )
    {
    }


    public function socialEventList(): ResponseData
    {
        $socialEvents = $this->socialEventService->getRepo()->getDashboardList();
        $result = $this->socialDashboardService->checkBtnSocialEvent($socialEvents);

        return $this->httpOk($result);
    }

    public function eventClassificationList(): ResponseData
    {
        $result = $this->eventClassificationService->getRepo()->getDashboardList();

        return $this->httpOk(EventClassificationDashboardResource::collection($result));
    }

    public function managementGroupList(): ResponseData
    {
        $managementGroups = $this->managementGroupService->getRepo()->getDashboardList();

        return $this->httpOk(ManagementGroupDashboardResource::collection($managementGroups));
    }

    public function supplierCard(): ResponseData
    {
        $history = $this->accessHistoryService->getSupplierSocialDashboard();
        $result = $this->socialDashboardService->checkBtnSupplier($history);

        return $this->httpOk($result);
    }

    public function productCard(): ResponseData
    {
        $history = $this->accessHistoryService->getProductSocialDashboard();

        return $this->httpOk(new AccessHistoryCardData(true, $history));
    }

    public function customerCard(): ResponseData
    {
        $history = $this->accessHistoryService->getCustomerSocialDashboard();
        $result = $this->socialDashboardService->checkBtnCustomer($history);

        return $this->httpOk($result);
    }

    public function summaryGraph(): ResponseData
    {
        $result = $this->socialDataService->getRepo()->getDashboardList();

        return $this->httpOk(new TopFiveYearDashboardResource($result));
    }

}
