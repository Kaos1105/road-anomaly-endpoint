<?php

namespace App\Http\Resources\SocialData;

use App\Http\Resources\Customer\CustomerShippingInfoResource;
use App\Http\Resources\Transfer\SocialDataTransferResource;
use App\Models\SocialData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   SocialData
 */
class ShippingInfoSocialDataResource extends JsonResource
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
            'customer' => $this->whenLoaded('customer',
                fn() => CustomerShippingInfoResource::make($this->customer)->setParams($this->resource)),
            'display_transfer_id' => $this->display_transfer_id,
            'display_transfer' => $this->whenLoaded('displayTransfer',
                fn() => SocialDataTransferResource::make($this->displayTransfer)),
        ];
    }
}
