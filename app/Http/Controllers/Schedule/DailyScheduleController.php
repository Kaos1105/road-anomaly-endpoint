<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Schedule\UpsertDailyScheduleRequest;
use App\Http\Resources\DailySchedule\DailyScheduleDetailResource;
use App\Services\ScheduleDaily\IDailyScheduleService;

class DailyScheduleController extends Controller
{
    public function __construct(
        private readonly IDailyScheduleService $dailyScheduleService,
    )
    {
    }

    public function upsertDaily(UpsertDailyScheduleRequest $request): ResponseData
    {
        $data = $request->validated();
        $dailySchedule = $this->dailyScheduleService->upsertDaily($data);
        return $this->httpOk(new DailyScheduleDetailResource($dailySchedule));
    }
}
