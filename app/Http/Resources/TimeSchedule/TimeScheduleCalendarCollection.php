<?php

namespace App\Http\Resources\TimeSchedule;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TimeScheduleCalendarCollection extends ResourceCollection
{
    public $collects = TimeScheduleCalendarItemResource::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
