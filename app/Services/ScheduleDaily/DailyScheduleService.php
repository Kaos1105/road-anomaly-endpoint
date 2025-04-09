<?php

namespace App\Services\ScheduleDaily;

use App\Http\DTO\QueryParam\DailyScheduleCalendarParam;
use App\Models\DailySchedule;
use App\Query\Schedule\DailyScheduleQuery;
use App\Repositories\ScheduleDaily\IDailyScheduleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DailyScheduleService implements IDailyScheduleService
{
    public function __construct(
        public IDailyScheduleRepository $dailyScheduleRepository,
    )
    {
    }

    public function getRepo(): IDailyScheduleRepository
    {
        return $this->dailyScheduleRepository;
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->dailyScheduleRepository->getPaginateList();
    }

    public function upsertDaily(array $dataInsert): DailySchedule
    {
        $dailyTemp = DailySchedule::make($dataInsert);
        $dailySchedule = $this->dailyScheduleRepository->checkExistDaily($dailyTemp->date, $dailyTemp->employee_id);
        if ($dailySchedule) {
            $dailySchedule = $this->dailyScheduleRepository->update($dataInsert, $dailySchedule->id);
        } else {
            $dailySchedule = $this->dailyScheduleRepository->create($dataInsert);
        }
        return $dailySchedule->load(['employee']);
    }

    public function getCalendarMonth(): Collection|array|null
    {
        $filter = request('filter');
        if ($filter['employee_id'] && $filter['date']) {
            $query = new DailyScheduleQuery(new Request());
            return $this->dailyScheduleRepository->getList($query->setCalendarFilterParam(new DailyScheduleCalendarParam($filter['date'], $filter['employee_id'])));
        }
        return null;
    }

}
