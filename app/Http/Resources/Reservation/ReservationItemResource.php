<?php

namespace App\Http\Resources\Reservation;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Facility\FacilityRelativeResource;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Reservation
 */
class ReservationItemResource extends JsonResource
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
            'facility' => $this->whenLoaded('facility', fn() => FacilityRelativeResource::make($this->facility)),
            'use_person_id' => $this->use_person_id,
            'use_person' => $this->whenLoaded('usePerson', fn() => EmployeeNameResource::make($this->usePerson)),
            'reservation_date' => Carbon::parse($this->reservation_date)->format(DateTimeEnum::DATE_FORMAT),
            'start_time' => Carbon::parse($this->start_time)->format(DateTimeEnum::TIME_FORMAT_V2),
            'end_time' => Carbon::parse($this->end_time)->format(DateTimeEnum::TIME_FORMAT_V2),
            'work_contents' => $this->work_contents,
        ];
    }
}
