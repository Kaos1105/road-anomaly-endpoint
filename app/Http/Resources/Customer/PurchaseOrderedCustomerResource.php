<?php

namespace App\Http\Resources\Customer;

use App\Helpers\SocialDataHelper;
use App\Http\Resources\Employee\SocialResponsibleResource;
use App\Models\Customer;
use App\Models\SocialData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Customer
 */
class PurchaseOrderedCustomerResource extends JsonResource
{
    protected SocialData|null $socialData;

    public function setParams(SocialData $socialData): self
    {
        $this->socialData = $socialData;
        return $this;
    }

    public function toArray(Request $request): array
    {
        $shippingInfo = SocialDataHelper::getShippingInfo($this->socialData, $this->resource);

        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'responsible_id' => $this->responsible_id,
            'responsible_employee' => $this->whenLoaded('responsibleEmployee',
                fn() => SocialResponsibleResource::make($this->responsibleEmployee)),
            'address_printing_1' => $this->address_printing_1,
            'address_printing_2' => $this->address_printing_2,
            'address_printing_3' => $this->address_printing_3,
            'address_printing_4' => $this->address_printing_4,
            'address_printing_5' => $this->address_printing_5,
            'address_printing_6' => $this->address_printing_6,
            'address_printing_7' => $this->address_printing_7,
            'shipping_info' => $shippingInfo,
        ];
    }
}
