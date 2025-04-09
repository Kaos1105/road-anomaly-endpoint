<?php

namespace App\Http\Resources\CompanyCalendar;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Models\CompanyCalendar;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CompanyCalendar
 */
class CompanyCalendarItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => DateTimeHelper::formatDateTime($this->date, DateTimeEnum::DATE_FORMAT),
            'calendar_classification' => $this->calendar_classification,
            'calendar_contents' => $this->calendar_contents,
            'work_classification' => $this->work_classification,
        ];
    }
}
