<?php

namespace App\Http\Resources\WeeklySchedule;

use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\WeeklySchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin WeeklySchedule
 */
class WeeklyScheduleItemResource extends JsonResource
{
    protected Collection|null $scheduleCalendar;

    public function setParams(?Collection $scheduleCalendar): self
    {
        $this->scheduleCalendar = $scheduleCalendar ?? null;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $schedule = [];
        if (isset($this->scheduleCalendar)) {
            $schedule = ['schedule' => $this->scheduleCalendar];
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', fn() => EmployeeNameResource::make($this->user)),
            'display_employee_id' => $this->display_employee_id,
            'display_employee' => $this->whenLoaded('displayEmployee', fn() => EmployeeNameResource::make($this->displayEmployee)),
            'display_weekly_classification' => $this->display_weekly_classification,
            'display_order' => $this->display_order,
            ...$schedule
        ];
    }
}
