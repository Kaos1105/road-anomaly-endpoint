<?php

namespace App\Http\Resources\SocialData;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Workflow\ExecutionOrderEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Customer\PurchaseOrderedCustomerResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Product\PreviousSocialDataProductResource;
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
class PurchaseOrderedSocialDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $orderedWorkflow = $this->relationLoaded('workflows') ? $this->workflows->filter(function (Workflow $workflow) {
            return $workflow->workflow_order == WorkflowOrderEnum::ORDER && $workflow->execution_type == ExecutionOrderEnum::ORDERED;
        })->first() : null;

        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'customer' => $this->whenLoaded('customer',
                fn() => (PurchaseOrderedCustomerResource::make($this->customer))->setParams($this->resource)),
            'display_transfer_id' => $this->display_transfer_id,
            'display_transfer' => $this->whenLoaded('displayTransfer', fn() => SocialDataTransferResource::make($this->displayTransfer)),
            'product_id' => $this->product_id,
            'product' => $this->whenLoaded('product', fn() => PreviousSocialDataProductResource::make($this->product)),
            'address_classification' => $this->address_classification,
            'product_name' => $this->product_name,
            'data_progress' => $this->data_progress,
            'total_amount' => $this->total_amount,
            'unit_price' => $this->unit_price,
            'tax_classification_1' => $this->tax_classification_1,
            'total_tax' => $this->total_tax,
            'shipping_cost' => $this->shipping_cost,
            'discount' => $this->discount,
            'accounting_department_id' => $this->accounting_department_id,
            'accounting_department' => $this->whenLoaded('accountingDepartment',
                fn() => DepartmentRelatedResource::make($this->accountingDepartment)),
            'order_date' => DateTimeHelper::formatDateTime($orderedWorkflow?->execution_at, DateTimeEnum::DATE_FORMAT),
            'use_classification' => $this->use_classification
        ];
    }
}
