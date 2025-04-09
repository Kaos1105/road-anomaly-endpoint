<?php

namespace App\Http\Resources\CompanyCalendar;

use App\Models\CompanyCalendar;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CompanyCalendar
 */
class CompanyCalendarDateResource extends JsonResource
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
            'calendar_classification' => $this->calendar_classification,
            'calendar_contents' => $this->calendar_contents,
            'work_classification' => $this->work_classification,
        ];
    }
}
