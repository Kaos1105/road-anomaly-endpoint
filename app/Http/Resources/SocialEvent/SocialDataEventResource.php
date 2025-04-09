<?php

namespace App\Http\Resources\SocialEvent;

use App\Http\Resources\EventClassification\EventClassificationRelatedResource;
use App\Http\Resources\ManagementGroup\ManagementGroupRelatedResource;
use App\Models\SocialEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SocialEvent
 */
class SocialDataEventResource extends JsonResource
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
            'event_id' => $this->event_id,
            'event_classification' => $this->whenLoaded('eventClassification', fn() => EventClassificationRelatedResource::make($this->eventClassification)),
            'group_id' => $this->group_id,
            'management_group' => $this->whenLoaded('managementGroup', fn() => ManagementGroupRelatedResource::make($this->managementGroup)),
            'event_title' => $this->event_title,
            'event_progress' => $this->event_progress,
            'use_classification' => $this->use_classification,
            'social_data_count' => $this->whenLoaded('socialData', fn() => $this->socialData->count()),
        ];
    }
}
