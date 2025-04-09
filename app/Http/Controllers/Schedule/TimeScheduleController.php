<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Schedule\UpsertTimeScheduleRequest;
use App\Http\Resources\TimeSchedule\TimeScheduleDetailResource;
use App\Http\Resources\TimeSchedule\TimeScheduleSearchCollection;
use App\Models\TimeSchedule;
use App\Services\ScheduleTime\ITimeScheduleService;

class TimeScheduleController extends Controller
{
    public function __construct(
        private readonly ITimeScheduleService $timeScheduleService,
    )
    {
    }

    public function index(): ResponseData
    {
        $data = $this->timeScheduleService->getPaginateList();

        return $this->httpOk(new TimeScheduleSearchCollection($data));
    }

    public function upsertTime(UpsertTimeScheduleRequest $request): ResponseData
    {
        $data = $request->validated();
        $timeSchedule = $this->timeScheduleService->upsertTime($data);
        return $this->httpOk(new TimeScheduleDetailResource($timeSchedule));
    }

    public function destroy(TimeSchedule $time): ResponseData
    {
        $this->timeScheduleService->getRepo()->delete($time->id);
        return $this->httpNoContent();
    }
}
