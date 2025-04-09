<?php

namespace App\Http\Resources\SocialData;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Workflow\ExecutionOrderEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Product\PreviousSocialDataProductResource;
use App\Http\Resources\SocialEvent\SocialEventDataResource;
use App\Http\Resources\Transfer\SocialDataTransferResource;
use App\Models\SocialData;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   SocialData
 */
class CustomerDetailSocialDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $productOrder = null;
        if ($this->whenLoaded('workflows')) {
            $workflowOrder = $this->workflows->filter(function (Workflow $workflow) {
                return $workflow->workflow_order == WorkflowOrderEnum::ORDER && $workflow->execution_type == ExecutionOrderEnum::ORDERED;
            })->first();
            if ($workflowOrder) {
                $productOrder = DateTimeHelper::formatDateTime($workflowOrder->execution_at, DateTimeEnum::YEAR_MONTH_FORMAT);
            }
        }

        $receipt = null;
        if ($this->whenLoaded('workflows')) {
            $receipt = $this->workflows->filter(function (Workflow $workflow) {
                return $workflow->workflow_order == WorkflowOrderEnum::RECEIPT;
            })->first();
        }

        return [
            'id' => $this->id,
            'social_event_id' => $this->social_event_id,
            'execution_at' => $productOrder,
            'social_event' => $this->whenLoaded('socialEvent',
                fn() => SocialEventDataResource::make($this->socialEvent)),
            'customer_id' => $this->customer_id,
            'display_transfer_id' => $this->display_transfer_id,
            'display_transfer' => $this->whenLoaded('displayTransfer',
                fn() => SocialDataTransferResource::make($this->displayTransfer)),
            'product_id' => $this->product_id,
            'product' => $this->whenLoaded('product', fn() => PreviousSocialDataProductResource::make($this->product)),
            'tax_3' => $this->tax_3,
            'total_amount' => $this->total_amount,
            'receipt' => $receipt?->execution_type,
        ];
    }
}
