<?php

namespace App\Http\Resources\TimeSchedule;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\TimeSchedule;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TimeSchedule
 * @property int $day_of_week
 * @property int $calendar_classification
 * @property string $calendar_contents
 * @property int $work_classification
 */
class TimeScheduleSearchItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @throws InvalidEnumKeyException
     */
    public function toArray($request): array
    {

        $companyCalendar = $this->relationLoaded('companyCalendar') ? [
            'company_calendar_classification' => $this->companyCalendar->calendar_classification ?? null,
            'company_calendar_contents' => $this->companyCalendar->calendar_contents ?? null,
            'company_work_classification' => $this->companyCalendar->work_classification ?? null,
        ] : [
            'company_calendar_classification' => null,
            'company_calendar_contents' => null,
            'company_work_classification' => null,
        ];
        return [
            'id' => $this->id,
            'day' => DisplayHelper::getNameFromDayOfWeek($this->day_of_week),
            'date' => DateTimeHelper::formatDateTime($this->date, DateTimeEnum::DATE_FORMAT),
            'start_time' => DateTimeHelper::formatDateTime($this->start_time, DateTimeEnum::HOUR_MINUTE_FORMAT),
            'end_time' => DateTimeHelper::formatDateTime($this->end_time, DateTimeEnum::HOUR_MINUTE_FORMAT),
            'employee_id' => $this->employee_id,
            'work_contents' => $this->work_contents,
            'work_place' => $this->work_place,
            'public_classification' => $this->public_classification,
            'updated_info' => $this->whenLoaded('updatedBy', fn() => EmployeeNameResource::make($this->updatedBy)),
            ...$companyCalendar
        ];
    }
}
