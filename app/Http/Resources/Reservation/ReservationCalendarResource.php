<?php

namespace App\Http\Resources\Reservation;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Reservation
 */
class ReservationCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'facility_id' => $this->facility_id,
            'use_person_id' => $this->use_person_id,
            'use_person' => $this->whenLoaded('usePerson', fn() => EmployeeNameResource::make($this->usePerson)),
            'reservation_date' => $this->reservation_date,
            'start_time' => Carbon::parse($this->start_time)->format(DateTimeEnum::TIME_FORMAT_V2),
            'end_time' => Carbon::parse($this->end_time)->format(DateTimeEnum::TIME_FORMAT_V2),
            'work_contents' => $this->work_contents,
            'created_info' => $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]),
            'updated_info' => $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]),
        ];
    }
}
