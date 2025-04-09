<?php

namespace App\Services\ScheduleTime;

use App\Models\TimeSchedule;
use App\Repositories\ScheduleTime\ITimeScheduleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ITimeScheduleService
{
    public function getRepo(): ITimeScheduleRepository;

    public function getPaginateList(): LengthAwarePaginator;

    public function upsertTime(array $dataInsert): TimeSchedule;

    public function getCalendarMonth(): Collection|array|null;


}
