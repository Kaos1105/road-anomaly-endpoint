<?php

namespace App\Services\ScheduleDaily;

use App\Models\DailySchedule;
use App\Repositories\ScheduleDaily\IDailyScheduleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IDailyScheduleService
{
    public function getRepo(): IDailyScheduleRepository;

    public function getPaginateList(): LengthAwarePaginator;

    public function upsertDaily(array $dataInsert): DailySchedule;

    public function getCalendarMonth(): Collection|array|null;


}
