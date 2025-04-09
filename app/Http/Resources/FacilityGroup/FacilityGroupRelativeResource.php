<?php

namespace App\Http\Resources\FacilityGroup;

use App\Http\Resources\Group\GroupDropdownResource;
use App\Models\FacilityGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FacilityGroup
 */
class FacilityGroupRelativeResource extends JsonResource
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
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'use_group' => $this->whenLoaded('useGroup', fn() => GroupDropdownResource::make($this->useGroup)),
        ];
    }
}
