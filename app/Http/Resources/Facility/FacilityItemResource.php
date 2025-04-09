<?php

namespace App\Http\Resources\Facility;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\Facility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Facility
 */
class FacilityItemResource extends JsonResource
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
            'facility_classification' => $this->facility_classification,
            'responsible_user_id' => $this->responsible_user_id,
            'responsible_user' => $this->whenLoaded('responsibleUser', fn() => EmployeeNameResource::make($this->responsibleUser)),
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
