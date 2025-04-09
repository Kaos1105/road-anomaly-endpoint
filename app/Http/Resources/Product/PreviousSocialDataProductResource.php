<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Http\Resources\Supplier\SupplierRelatedResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class PreviousSocialDataProductResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'product_classification' => $this->product_classification,
            'supplier_id' => $this->supplier_id,
            'use_classification' => $this->use_classification,
            'supplier' => $this->whenLoaded('supplier', fn() => SupplierRelatedResource::make($this->supplier)),
            'site' => $this->whenLoaded('site', fn() => SiteRelatedResource::make($this->site)),
            'company' => $this->whenLoaded('site', fn() => $this->site->relationLoaded('company')
                ? CompanyRelatedResource::make($this->site->company) : null),
        ];
    }
}
