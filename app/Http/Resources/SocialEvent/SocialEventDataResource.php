<?php

namespace App\Http\Resources\SocialEvent;

use App\Http\Resources\EventClassification\EventClassificationRelatedResource;
use App\Models\SocialEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SocialEvent
 */
class SocialEventDataResource extends JsonResource
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
            'event_title' => $this->event_title,
            'use_classification' => $this->use_classification,
        ];
    }
}
