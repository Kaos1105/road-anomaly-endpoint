<?php

namespace App\Http\Resources\DailySchedule;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\DailySchedule;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin DailySchedule
 */
class DailyScheduleDetailResource extends JsonResource
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
            'date' => DateTimeHelper::formatDateTime($this->date, DateTimeEnum::DATE_FORMAT_V2),
            'work_classification' => $this->work_classification,
            'employee_id' => $this->employee_id,
            'employee' => $this->whenLoaded('employee', fn() => EmployeeNameResource::make($this->employee)),
        ];
    }
}
