<?php

namespace App\Http\Resources\SocialEvent;

use App\Enums\Common\DateTimeEnum;
use App\Enums\SocialEvent\EventProgressClassificationEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\EventClassification\EventClassificationRelatedResource;
use App\Http\Resources\ManagementGroup\ManagementGroupRelatedResource;
use App\Models\SocialEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SocialEvent
 */
class SocialEventDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $endDate = match ($this->event_progress) {
            EventProgressClassificationEnum::UNDER_WAY => $this->creation_deadline,
            EventProgressClassificationEnum::COMPLETED => $this->planned_completion,
            default => null,
        };
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'event_classification' => $this->whenLoaded('eventClassification',
                fn() => EventClassificationRelatedResource::make($this->eventClassification)),
            'group_id' => $this->group_id,
            'management_group' => $this->whenLoaded('managementGroup',
                fn() => ManagementGroupRelatedResource::make($this->managementGroup)),
            'event_title' => $this->event_title,
            'event_progress' => $this->event_progress,
            'use_classification' => $this->use_classification,
            'start_date' => DateTimeHelper::formatDateTime($this->planned_start, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($endDate, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
