<?php

namespace App\Http\Resources\Facility;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\FacilityGroup\FacilityGroupRelativeResource;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Facility
 */
class FacilityDetailResource extends JsonResource
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
            'facility_group_id' => $this->facility_group_id,
            'facility_group' => $this->whenLoaded('facilityGroup', fn() => FacilityGroupRelativeResource::make($this->facilityGroup)),
            'responsible_user_id' => $this->responsible_user_id,
            'responsible_user' => $this->whenLoaded('responsibleUser', fn() => EmployeeNameResource::make($this->responsibleUser)),
            'name' => $this->name,
            'usage_method' => $this->usage_method,
            'facility_classification' => $this->facility_classification,
            'aggregation_classification' => $this->aggregation_classification,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'memo' => $this->memo,
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
