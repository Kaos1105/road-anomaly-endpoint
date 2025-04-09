<?php

namespace App\Http\Resources\CustomerCategory;

use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\CustomerCategory;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Workflow;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin CustomerCategory
 */
class CustomerCategoryWithAggregationResource extends JsonResource
{
    protected SocialEvent $socialEvent;
    public Collection $paidWorkflows;

    public function setParams(SocialEvent $socialEvent): self
    {
        $this->socialEvent = $socialEvent;
        $this->setPaidWorkflows();
        
        return $this;
    }

    protected function setPaidWorkflows(): void
    {
        $socialData = $this->socialEvent->relationLoaded('socialData') ? $this->socialEvent->socialData->filter(function (SocialData $socialData) {
            return $socialData->customer->category_name == $this->name;
        }) : collect();

        $this->paidWorkflows = $socialData->filter(function (SocialData $socialData) {
            return $socialData->relationLoaded('workflows') && $socialData->workflows->contains(function (Workflow $workflow) {
                    return $workflow->workflow_order == WorkflowOrderEnum::PAYMENT && $workflow->execution_type == ExecutionPaymentEnum::PAID;
                });
        });
    }

    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'number_of_payment' => $this->paidWorkflows->count(),
            'amount_of_payment' => $this->paidWorkflows->sum(function (SocialData $socialData) {
                return $socialData->total_amount;
            }),
        ];
    }
}
