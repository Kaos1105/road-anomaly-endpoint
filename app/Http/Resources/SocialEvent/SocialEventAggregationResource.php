<?php

namespace App\Http\Resources\SocialEvent;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Workflow\ExecutionReceiptEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
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
class SocialEventAggregationResource extends JsonResource
{

    public function getSocialDataAggregation(int $workflowOrder, int $executionType)
    {
        return $this->socialData->filter(function (SocialData $socialData) use ($workflowOrder, $executionType) {
            return $socialData->relationLoaded('workflows') && $socialData->workflows
                    ->contains(function (Workflow $workflow) use ($workflowOrder, $executionType) {
                        return $workflow->workflow_order == $workflowOrder && $workflow->execution_type == $executionType;
                    });
        });
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $receiptSocialData = collect();
        $rejectedSocialData = collect();
        $cancelledSocialData = collect();
        $paidSocialData = collect();

        if ($this->relationLoaded('socialData')) {
            $receiptSocialData = $this->getSocialDataAggregation(WorkflowOrderEnum::RECEIPT, ExecutionReceiptEnum::RECEIVED);

            $rejectedSocialData = $this->getSocialDataAggregation(WorkflowOrderEnum::RECEIPT, ExecutionReceiptEnum::REJECTED);

            $cancelledSocialData = $this->getSocialDataAggregation(WorkflowOrderEnum::RECEIPT, ExecutionReceiptEnum::CANCELLED);

            $paidSocialData = $this->getSocialDataAggregation(WorkflowOrderEnum::PAYMENT, ExecutionReceiptEnum::RECEIVED);
        }

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
            'number_of_receipt' => $receiptSocialData->count(),
            'number_of_rejected' => $rejectedSocialData->count(),
            'number_of_cancelled' => $cancelledSocialData->count(),
            'number_of_payment' => $paidSocialData->count(),
            'amount_of_payment' => $paidSocialData->sum(function (SocialData $socialData) {
                return $socialData->total_amount;
            }),
            'use_classification' => $this->use_classification,
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
