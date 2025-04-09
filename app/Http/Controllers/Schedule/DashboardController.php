<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\DTO\Schedule\MonthCalendarData;
use App\Services\CompanyCalendar\ICompanyCalendarService;
use App\Services\ScheduleDaily\IDailyScheduleService;
use App\Services\ScheduleTime\ITimeScheduleService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly ICompanyCalendarService $companyCalendarService,
        private readonly IDailyScheduleService   $dailyScheduleService,
        private readonly ITimeScheduleService    $timeScheduleService,
    )
    {
    }

    public function calendar(): ResponseData
    {
        $companyCalendar = $this->companyCalendarService->getCalendarMonth();
        $dailySchedule = $this->dailyScheduleService->getCalendarMonth();
        $timeSchedule = $this->timeScheduleService->getCalendarMonth();

        return $this->httpOk(MonthCalendarData::mapCollection($dailySchedule, $companyCalendar, $timeSchedule)->toArray());
    }
}
