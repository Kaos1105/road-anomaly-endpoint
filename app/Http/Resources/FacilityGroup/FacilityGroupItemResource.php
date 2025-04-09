<?php

namespace App\Http\Resources\FacilityGroup;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Group\GroupDropdownResource;
use App\Models\FacilityGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FacilityGroup
 */
class FacilityGroupItemResource extends JsonResource
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
            'number_of_facilities' => $this->facilities_count,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
