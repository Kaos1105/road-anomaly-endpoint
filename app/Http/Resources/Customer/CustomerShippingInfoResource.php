<?php

namespace App\Http\Resources\Customer;

use App\Enums\SocialCustomer\AddressClassificationEnum;
use App\Models\Customer;
use App\Models\SocialData;
use Illuminate\Http\Request;

/**
 * @mixin Customer
 */
class CustomerShippingInfoResource extends SocialDataCustomerResource
{
    protected SocialData|null $socialData;

    public function setParams(SocialData $socialData): self
    {
        $this->socialData = $socialData;
        return $this;
    }

    public function toArray(Request $request): array
    {
        $filter = request('filter');
        $addressClassification = $filter && !empty($filter['address_classification']) ? (int)$filter['address_classification'] : $this->socialData->address_classification;
     
        $shippingInfo = match ($addressClassification) {
            AddressClassificationEnum::HOME => [
                'post_code' => $this->employee?->post_code,
                'address_1' => $this->employee?->address_1,
                'address_2' => $this->employee?->address_2,
                'address_3' => $this->employee?->address_3,
                'phone' => $this->employee?->phone,
            ],
            AddressClassificationEnum::COMPANY => [
                'post_code' => $this->socialData->displayTransfer?->site?->post_code,
                'address_1' => $this->socialData->displayTransfer?->site?->address_1,
                'address_2' => $this->socialData->displayTransfer?->site?->address_2,
                'address_3' => $this->socialData->displayTransfer?->site?->address_3,
                'phone' => $this->socialData->displayTransfer?->site?->phone,
            ],
            AddressClassificationEnum::DESIGNATION => [
                'post_code' => $this->specified_post_code,
                'address_1' => $this->specified_address_1,
                'address_2' => $this->specified_address_2,
                'address_3' => $this->specified_address_3,
                'phone' => $this->specified_phone,
            ],
            default => [
                'post_code' => null,
                'address_1' => null,
                'address_2' => null,
                'address_3' => null,
                'phone' => null,
            ],
        };

        return [
            ...parent::toArray($request),
            'shipping_info' => $shippingInfo,
        ];
    }
}
