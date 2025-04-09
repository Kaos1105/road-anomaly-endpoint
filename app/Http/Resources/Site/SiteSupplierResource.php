<?php

namespace App\Http\Resources\Site;

use App\Http\Resources\Company\CompanyShortNameResource;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Site
 */
class SiteSupplierResource extends JsonResource
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
            'company_id' => $this->company_id,
            'code' => $this->code,
            'long_name' => $this->long_name,
            'short_name' => $this->short_name,
            'previous_name' => $this->previous_name,
            'previous_name_flg' => $this->previous_name_flg,
            'use_classification' => $this->use_classification,
            'post_code' => $this->post_code,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'address_3' => $this->address_3,
            'phone' => $this->phone,
            'company' => $this->whenLoaded('company', fn() => CompanyShortNameResource::make($this->company)),
        ];
    }
}
