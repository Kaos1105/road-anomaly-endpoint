<?php

namespace App\Http\Resources\Facility;

use App\Http\Resources\Reservation\ReservationItemResource;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Facility
 */
class FacilityReservationItemPortalResource extends JsonResource
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
            'name' => $this->name,
            'use_classification' => $this->use_classification,
            'facility_group_id' => $this->facility_group_id,
            'display_order' => $this->display_order,
            'reservation' => $this->relationLoaded('reservations') ? $this->whenLoaded('reservations', fn() => ReservationItemResource::make($this->reservations->first())) : null
        ];
    }
}
