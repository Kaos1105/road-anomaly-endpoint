<?php

namespace App\Repositories\ScheduleDaily;

use App\Models\DailySchedule;
use App\Query\Schedule\DailyScheduleQuery;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IDailyScheduleRepository extends RepositoryInterface
{
    public function getDetail(DailySchedule $detail): DailySchedule;

    public function getPaginateList(): LengthAwarePaginator;

    public function checkExistDaily(Carbon|string $date, int $employeeId): DailySchedule|null;

    public function getList(DailyScheduleQuery $query): Collection;

}
