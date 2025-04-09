<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Site\SiteDropdownResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductDropdownResource extends JsonResource
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
            'product_classification' => $this->product_classification,
            'company' => $this->whenLoaded('site', function () {
                return $this->site->relationLoaded('company') ?
                    CompanyRelatedResource::make($this->site->company) : null;
            }),
            'site' => $this->whenLoaded('site', fn() => SiteDropdownResource::make($this->site)),
            'code' => $this->code,
            'name' => $this->name,
            'unit_price' => $this->unit_price,
            'tax_classification_1' => $this->tax_classification_1,
            'tax_classification_2' => $this->tax_classification_2,
            'tax_classification_3' => $this->tax_classification_3,
            'use_classification' => $this->use_classification,
        ];
    }
}
