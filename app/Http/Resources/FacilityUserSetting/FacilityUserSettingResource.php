<?php

namespace App\Http\Resources\FacilityUserSetting;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\FacilityGroup\FacilityGroupRelativeResource;
use App\Models\FacilityUserSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FacilityUserSetting
 */
class FacilityUserSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'facility_group_id' => $this->facility_group_id ?? null,
            'facility_group' => $this->relationLoaded('facilityGroup') ? $this->whenLoaded('facilityGroup', fn() => FacilityGroupRelativeResource::make($this->facilityGroup)) : null,
            'holiday_display' => $this->holiday_display ?? null,
            'created_info' => $this->relationLoaded('createdBy') ? $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]) : null,
            'updated_info' => $this->relationLoaded('updatedBy') ? $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]) : null,
        ];

    }
}
