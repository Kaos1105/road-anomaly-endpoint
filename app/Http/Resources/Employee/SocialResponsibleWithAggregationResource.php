<?php

namespace App\Http\Resources\Employee;

use App\Enums\Workflow\ExecutionApprovedEnum;
use App\Enums\Workflow\ExecutionDecisionEnum;
use App\Enums\Workflow\ExecutionDraftEnum;
use App\Enums\Workflow\ExecutionReceiptEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\Employee;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Transform the resource into an array.
 *
 * @mixin   Employee
 */
class SocialResponsibleWithAggregationResource extends JsonResource
{
    protected SocialEvent $socialEvent;
    public Collection $drafterSocialData;
    public int $draftedCount = 0;
    public int $approvedCount = 0;
    public int $decidedCount = 0;
    public int $receiptCount = 0;

    protected function calculateAggregation(): void
    {
        $this->drafterSocialData = $this->socialEvent->relationLoaded('socialData') ? $this->socialEvent->socialData->filter(function (SocialData $socialData) {
            return $socialData->customer->responsible_id == $this->id;
        }) : collect();

        $this->drafterSocialData->each(function (SocialData $socialData) {
            if ($socialData->relationLoaded('workflows')) {
                $socialData->workflows->each(function (Workflow $workflow) {
                    if ($workflow->workflow_order == WorkflowOrderEnum::DRAFTING && $workflow->execution_type == ExecutionDraftEnum::DRAFTED) {
                        $this->draftedCount += 1;
                    }
                    if ($workflow->workflow_order == WorkflowOrderEnum::APPROVED && $workflow->execution_type == ExecutionApprovedEnum::APPROVED) {
                        $this->approvedCount += 1;
                    }
                    if ($workflow->workflow_order == WorkflowOrderEnum::DECISION && $workflow->execution_type == ExecutionDecisionEnum::DECIDED) {
                        $this->decidedCount += 1;
                    }
                    if ($workflow->workflow_order == WorkflowOrderEnum::RECEIPT && $workflow->execution_type == ExecutionReceiptEnum::RECEIVED) {
                        $this->receiptCount += 1;
                    }
                });
            }
        });

    }

    public function setParams(SocialEvent $socialEvent): self
    {
        $this->socialEvent = $socialEvent;
        $this->calculateAggregation();
        return $this;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'maiden_name' => $this->maiden_name,
            'previous_name_flg' => $this->previous_name_flg,
            'use_classification' => $this->use_classification,
            'served_customer_count' => $this->drafterSocialData->count(),
            'drafted_social_data_count' => $this->draftedCount,
            'approved_social_data_count' => $this->approvedCount,
            'decided_social_data_count' => $this->decidedCount,
            'receipt_social_data_count' => $this->receiptCount,
        ];
    }
}
