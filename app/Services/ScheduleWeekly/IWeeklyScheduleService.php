<?php

namespace App\Services\ScheduleWeekly;

use App\Http\DTO\WeeklySchedule\ScheduleDragNDropData;
use App\Repositories\ScheduleWeekly\IWeeklyScheduleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IWeeklyScheduleService
{
    public function getRepo(): IWeeklyScheduleRepository;

    public function getPaginateList(): LengthAwarePaginator;

    public function updateDragNDropOrder(ScheduleDragNDropData $start, ScheduleDragNDropData $end): Collection;


}
