<?php

namespace App\Http\Resources\SocialEvent;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\EventClassification\EventClassificationRelatedResource;
use App\Http\Resources\ManagementGroup\ManagementGroupRelatedResource;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SocialEvent
 */
class SocialEventItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $paidWorkflow = $this->relationLoaded('socialData') ?
            $this->socialData->filter(function (SocialData $socialData) {
                return $socialData->relationLoaded('workflows') && $socialData->workflows->contains(function (Workflow $workflow) {
                        return $workflow->workflow_order == WorkflowOrderEnum::PAYMENT && $workflow->execution_type == ExecutionPaymentEnum::PAID;
                    });
            }) : collect();

        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'event_classification' => $this->whenLoaded('eventClassification', fn() => EventClassificationRelatedResource::make($this->eventClassification)),
            'group_id' => $this->group_id,
            'management_group' => $this->whenLoaded('managementGroup', fn() => ManagementGroupRelatedResource::make($this->managementGroup)),
            'event_title' => $this->event_title,
            'event_progress' => $this->event_progress,
            'planned_start' => DateTimeHelper::formatDateTime($this->planned_start, DateTimeEnum::DATE_FORMAT),
            'planned_completion' => DateTimeHelper::formatDateTime($this->planned_completion, DateTimeEnum::DATE_FORMAT),
            'social_data_count' => $this->whenLoaded('socialData', fn() => $this->socialData->count()),
            'number_of_payment' => $paidWorkflow->count(),
            'amount_of_payment' => $paidWorkflow->sum(function (SocialData $socialData) {
                return $socialData->total_amount;
            }),
            'use_classification' => $this->use_classification,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
