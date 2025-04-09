<?php

namespace App\Services\Dashboard;

use App\Http\DTO\Announcement\AnnouncementCardDashboardData;
use App\Http\DTO\Portal\FacilityCardData;
use App\Http\DTO\Portal\ScheduleManagementCardData;
use App\Http\DTO\Portal\SubSystemCardData;
use App\Http\DTO\Portal\WeeklyScheduleCardData;

interface IMainDashboardService
{
    public function getContentCardBySubSystem(): SubSystemCardData;

    public function getAnnouncementCardBySubSystem(): AnnouncementCardDashboardData;

    public function getWeeklySchedule(): WeeklyScheduleCardData|null;

    public function getScheduleManagementCard(): ScheduleManagementCardData|null;

    public function getFacilityCard(): FacilityCardData|null;

}
