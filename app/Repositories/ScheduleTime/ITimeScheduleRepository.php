<?php

namespace App\Repositories\ScheduleTime;

use App\Models\TimeSchedule;
use App\Query\Schedule\TimeScheduleQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ITimeScheduleRepository extends RepositoryInterface
{
    public function getDetail(TimeSchedule $detail): TimeSchedule;

    public function getPaginateList(): LengthAwarePaginator;

    public function getList(TimeScheduleQuery $query): Collection;

}
