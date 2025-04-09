<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\DTO\Announcement\AnnouncementCardDashboardData;
use App\Http\DTO\ResponseData;
use App\Http\Resources\AccessHistory\AccessItemResource;
use App\Http\Resources\Announcement\AnnouncementCardDashboardResource;
use App\Services\AccessHistory\IAccessHistoryService;
use App\Services\Dashboard\IMainDashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly IMainDashboardService $mainDashboardService,
    )
    {

    }

    public function getCardBySystem(): ResponseData
    {
        $result = $this->mainDashboardService->getContentCardBySubSystem();

        return $this->httpOk($result);
    }

    public function getAnnouncementCardBySystem(): ResponseData
    {
        $announcementCard = $this->mainDashboardService->getAnnouncementCardBySubSystem();
        return $this->httpOk($announcementCard);
    }

    public function getFacilityReservationCard(): ResponseData
    {
        $card = $this->mainDashboardService->getFacilityCard();
        return $this->httpOk($card);
    }


    public function getWeeklySchedule(): ResponseData
    {
        $card = $this->mainDashboardService->getWeeklySchedule();

        return $this->httpOk($card);
    }

    public function getScheduleManagement(): ResponseData
    {
        $card = $this->mainDashboardService->getScheduleManagementCard();

        return $this->httpOk($card);
    }
}
