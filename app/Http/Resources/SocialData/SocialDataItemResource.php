<?php

namespace App\Http\Resources\SocialData;

use App\Helpers\SocialDataHelper;
use App\Http\Resources\Customer\SocialCustomerResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Product\PreviousSocialDataProductResource;
use App\Http\Resources\SocialEvent\SocialEventDataResource;
use App\Http\Resources\Transfer\SocialDataTransferResource;
use App\Http\Resources\Workflow\WorkflowItemResource;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   SocialData
 */
class SocialDataItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $socialEvent = $this->relationLoaded('socialEvent') ? $this->socialEvent : null;
        [$isEnabledBtnEdit, $isEnabledBtnWorkflow] = SocialDataHelper::socialDataBtnFLg($this->resource, $socialEvent);

        return [
            'id' => $this->id,
            'social_event' => $this->whenLoaded('socialEvent',
                fn() => SocialEventDataResource::make($this->socialEvent)),
            'customer_id' => $this->customer_id,
            'customer' => $this->whenLoaded('customer',
                fn() => SocialCustomerResource::make($this->customer)),
            'display_transfer_id' => $this->display_transfer_id,
            'display_transfer' => $this->whenLoaded('displayTransfer',
                fn() => SocialDataTransferResource::make($this->displayTransfer)),
            'product_id' => $this->product_id,
            'product' => $this->whenLoaded('product',
                fn() => PreviousSocialDataProductResource::make($this->product)),
            'product_name' => $this->product_name,
            'data_progress' => $this->data_progress,
            'total_amount' => $this->total_amount,
            'total_tax' => $this->total_tax,
            'unit_price' => $this->unit_price,
            'tax_classification_1' => $this->tax_classification_1,
            'accounting_department_id' => $this->accounting_department_id,
            'accounting_department' => $this->whenLoaded('accountingDepartment',
                fn() => DepartmentRelatedResource::make($this->accountingDepartment)),
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'workflow_message' => explode("\n", $this->comment_history)[0],
            'workflows' => $this->whenLoaded('workflows',
                fn() => $this->workflows->map(function (Workflow $workFlow) {
                    return WorkflowItemResource::make($workFlow)->setParams($this->socialEvent);
                })),
            'is_enable_btn_flg' => [
                'end_btn' => null,
                'edit_btn' => $isEnabledBtnEdit,
                'workflow_btn' => $isEnabledBtnWorkflow
            ]
        ];
    }
}
