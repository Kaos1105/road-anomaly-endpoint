<?php

namespace App\Services\ScheduleWeekly;

use App\Http\DTO\WeeklySchedule\ScheduleDragNDropData;
use App\Models\WeeklySchedule;
use App\Repositories\ScheduleWeekly\IWeeklyScheduleRepository;

use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class WeeklyScheduleService implements IWeeklyScheduleService
{
    public function __construct(
        public IWeeklyScheduleRepository $weeklyScheduleRepository,

    )
    {
    }

    public function getRepo(): IWeeklyScheduleRepository
    {
        return $this->weeklyScheduleRepository;
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->weeklyScheduleRepository->getPaginateList();
    }

    public function updateDragNDropOrder(ScheduleDragNDropData $start, ScheduleDragNDropData $end): Collection
    {
        if ($start->displayOrder < $end->displayOrder) {
            // Down
            $schedules = $this->weeklyScheduleRepository->getUpdatingSchedule($start->displayOrder, $end->displayOrder);
            $updateScheduleStatement = $schedules->map(function (WeeklySchedule $weeklySchedule) {
                $newDisplay = $weeklySchedule->display_order - 1;
                return " WHEN {$weeklySchedule->id} THEN {$newDisplay}";
            })->implode(' ');
        } else {
            // Up
            $schedules = $this->weeklyScheduleRepository->getUpdatingSchedule($end->displayOrder - 1, $start->displayOrder - 1);
            $updateScheduleStatement = $schedules->map(function (WeeklySchedule $weeklySchedule) {
                $newDisplay = $weeklySchedule->display_order + 1;
                return " WHEN {$weeklySchedule->id} THEN {$newDisplay}";
            })->implode(' ');
        }

        $this->switchScheduleOrder($start, $end, $updateScheduleStatement, $schedules);

        return $this->getRepo()->getUserWeeklySchedules();
    }


    private function switchScheduleOrder(ScheduleDragNDropData $start, ScheduleDragNDropData $end, string $updateScheduleStatement, Collection $schedules): void
    {
        $scheduleIds = $schedules->map(fn(WeeklySchedule $weeklySchedule) => $weeklySchedule->id)->toArray();
        $scheduleIds[] = $start->id;
        $updateScheduleStatement .= " WHEN {$start->id} THEN {$end->displayOrder} ";

        WeeklySchedule::query()->whereIn('id', $scheduleIds)->update([
            'display_order' => DB::raw("CASE id " . $updateScheduleStatement . " END "),
        ]);
    }

}
