<?php

namespace App\Services\ScheduleTime;

use App\Enums\Company\IndependentEnum;
use App\Http\DTO\QueryParam\TimeScheduleCalendarParam;
use App\Models\TimeSchedule;
use App\Query\Schedule\TimeScheduleQuery;
use App\Repositories\ScheduleTime\ITimeScheduleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TimeScheduleService implements ITimeScheduleService
{
    public function __construct(
        public ITimeScheduleRepository $timeScheduleRepository,
    )
    {
    }

    public function getRepo(): ITimeScheduleRepository
    {
        return $this->timeScheduleRepository;
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        $request = request();
        $filter = $request['filter'];
        if (empty($filter['search'])) {
            $filter['id'] = IndependentEnum::INDEPENDENT;
            $request->merge(['filter' => $filter]);
        }

        return $this->timeScheduleRepository->getPaginateList();
    }

    public function upsertTime(array $dataInsert): TimeSchedule
    {
        $timeTemp = TimeSchedule::make($dataInsert);

        if ($timeTemp->id) {
            $dailySchedule = $this->timeScheduleRepository->update($dataInsert, $timeTemp->id);
        } else {
            $dailySchedule = $this->timeScheduleRepository->create($dataInsert);
        }
        return $dailySchedule->load(['employee', 'group']);
    }


    public function getCalendarMonth(): Collection|array|null
    {
        $filter = request('filter');
        if ($filter['employee_id'] && $filter['date']) {
            $query = new TimeScheduleQuery(new Request());
            return $this->timeScheduleRepository->getList($query->setCalendarFilterParam(new TimeScheduleCalendarParam($filter['date'], $filter['employee_id'])));
        }
        return null;
    }

}
