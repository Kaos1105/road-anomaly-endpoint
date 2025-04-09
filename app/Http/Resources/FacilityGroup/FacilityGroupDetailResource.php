<?php

namespace App\Http\Resources\FacilityGroup;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Group\GroupDropdownResource;
use App\Models\FacilityGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FacilityGroup
 */
class FacilityGroupDetailResource extends JsonResource
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
            'use_group_id' => $this->use_group_id,
            'use_group' => $this->whenLoaded('useGroup', fn() => GroupDropdownResource::make($this->useGroup)),
            'name' => $this->name,
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
