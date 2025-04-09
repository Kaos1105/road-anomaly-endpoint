<?php

namespace App\Http\Resources\SocialData;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Customer\SocialDataCustomerResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Product\ProductDropdownResource;
use App\Http\Resources\SocialEvent\SocialEventDataResource;
use App\Http\Resources\Transfer\SocialDataTransferResource;
use App\Models\SocialData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   SocialData
 */
class SocialDataEditDetail extends JsonResource
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
            'social_event_id' => $this->social_event_id,
            'social_event' => $this->whenLoaded('socialEvent',
                fn() => SocialEventDataResource::make($this->socialEvent)),
            'customer_id' => $this->customer_id,
            'customer' => $this->whenLoaded('customer', fn() => SocialDataCustomerResource::make($this->customer))->setParams($this->resource),
            'display_transfer_id' => $this->display_transfer_id,
            'display_transfer' => $this->whenLoaded('displayTransfer', fn() => SocialDataTransferResource::make($this->displayTransfer)),
            'product_id' => $this->product_id,
            'product' => $this->whenLoaded('product',
                fn() => ProductDropdownResource::make($this->product)),
            'product_name' => $this->product_name,
            'unit_price' => $this->unit_price,
            'discount' => $this->discount,
            'tax_classification_1' => $this->tax_classification_1,
            'tax_1' => $this->tax_1,
            'shipping_cost' => $this->shipping_cost,
            'tax_classification_2' => $this->tax_classification_2,
            'tax_2' => $this->tax_2,
            'other' => $this->other,
            'tax_classification_3' => $this->tax_classification_3,
            'tax_3' => $this->tax_3,
            'total_amount' => $this->total_amount,
            'total_tax' => $this->total_tax,
            'purpose' => $this->purpose,
            'result' => $this->result,
            'processing_site' => $this->processing_site,
            'accounting_company' => $this->accounting_company,
            'accounting_department_id' => $this->accounting_department_id,
            'accounting_department' => $this->whenLoaded('accountingDepartment', fn() => DepartmentRelatedResource::make($this->accountingDepartment)),
            'address_classification' => $this->address_classification,
            'data_progress' => $this->data_progress,
            'comment_history' => $this->comment_history,
            'memo' => $this->memo,
            'display_order' => $this->display_order,
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
