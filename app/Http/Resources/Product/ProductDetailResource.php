<?php

namespace App\Http\Resources\Product;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Site\SiteSupplierResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductDetailResource extends JsonResource
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
            'memo' => $this->memo,
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
