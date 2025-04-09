<?php

namespace App\Http\Resources\TimeSchedule;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Schedule\PublicClassificationEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Group\GroupDropdownResource;
use App\Models\TimeSchedule;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TimeSchedule
 */
class TimeScheduleCalendarItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'start_time' => DateTimeHelper::formatDateTime($this->start_time, DateTimeEnum::HOUR_MINUTE_FORMAT),
            'end_time' => DateTimeHelper::formatDateTime($this->end_time, DateTimeEnum::HOUR_MINUTE_FORMAT),
            'work_contents' => $this->work_contents,
            'work_place' => $this->work_place,
            'public_classification' => $this->public_classification,
            'public_group_id' => $this->public_group_id,
            'group' => $this->public_classification == PublicClassificationEnum::PUBLIC_GROUP ? $this->whenLoaded('group', fn() => GroupDropdownResource::make($this->group)) : null,
            'updated_info' => $this->whenLoaded('updatedBy', fn() => EmployeeNameResource::make($this->updatedBy)),
            
        ];
    }
}
