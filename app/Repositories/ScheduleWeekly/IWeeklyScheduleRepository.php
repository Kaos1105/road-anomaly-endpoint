<?php

namespace App\Repositories\ScheduleWeekly;

use App\Models\WeeklySchedule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IWeeklyScheduleRepository extends RepositoryInterface
{
    public function getDetail(WeeklySchedule $detail): WeeklySchedule;

    public function getPaginateList(): LengthAwarePaginator;

    public function getUserWeeklySchedules(array $load = ['user', 'displayEmployee']): Collection;

    public function upsertSchedules(array $upsertData): Collection;

    public function getUpdatingSchedule(int $start, int $end): Collection;

}
