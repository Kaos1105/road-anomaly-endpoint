<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\DTO\WeeklySchedule\ScheduleDragNDropData;
use App\Http\Requests\WeeklySchedule\DragNDropScheduleRequest;
use App\Http\Requests\WeeklySchedule\UpsertWeeklyScheduleRequest;
use App\Http\Resources\WeeklySchedule\WeeklyScheduleItemResource;
use App\Services\ScheduleWeekly\IWeeklyScheduleService;

class WeeklyScheduleController extends Controller
{
    public function __construct(
        private readonly IWeeklyScheduleService $weeklyScheduleService,
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->weeklyScheduleService->getRepo()->getUserWeeklySchedules();

        return $this->httpOk(WeeklyScheduleItemResource::collection($result));
    }

    public function upsertWeekly(UpsertWeeklyScheduleRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->weeklyScheduleService->getRepo()->upsertSchedules($data['weekly_schedules']);

        return $this->httpOk(WeeklyScheduleItemResource::collection($result));
    }

    public function updateDisplayOrder(DragNDropScheduleRequest $request): ResponseData
    {
        $data = $request->validated();
        $start = ScheduleDragNDropData::from($data['schedule_start']);
        $end = ScheduleDragNDropData::from($data['schedule_end']);
        $result = $this->weeklyScheduleService->updateDragNDropOrder($start, $end);

        return $this->httpOk(WeeklyScheduleItemResource::collection($result));
    }

}
