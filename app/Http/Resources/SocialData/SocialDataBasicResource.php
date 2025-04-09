<?php

namespace App\Http\Resources\SocialData;

use App\Http\Resources\Transfer\SocialDataTransferResource;
use App\Models\SocialData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   SocialData
 */
class SocialDataBasicResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'display_transfer_id' => $this->display_transfer_id,
            'display_transfer' => $this->whenLoaded('displayTransfer',
                fn() => SocialDataTransferResource::make($this->displayTransfer)),
            'product_id' => $this->product_id,
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
            'address_classification' => $this->address_classification,
            'data_progress' => $this->data_progress,
            'comment_history' => $this->comment_history,
            'memo' => $this->memo,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
        ];
    }
}
