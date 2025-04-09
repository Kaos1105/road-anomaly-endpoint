<?php

namespace App\Http\Resources\Product;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Site\SiteSupplierResource;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductItemResource extends JsonResource
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
            'site' =>  $this->whenLoaded('site', fn() => SiteSupplierResource::make($this->site)),
            'code' => $this->code,
            'name' => $this->name,
            'unit_price' => $this->unit_price,
            'tax_classification_1' => $this->tax_classification_1,
            'tax_classification_2' => $this->tax_classification_2,
            'tax_classification_3' => $this->tax_classification_3,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
