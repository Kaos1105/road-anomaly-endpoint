<?php

namespace App\Http\Resources\SocialData;

use App\Http\Resources\Product\PreviousSocialDataProductResource;
use App\Models\Employee;
use App\Models\SocialData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   SocialData
 */
class PreviousSocialData extends JsonResource
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
            'product_id' => $this->product_id,
            'product' =>$this->whenLoaded('product', fn() =>
                PreviousSocialDataProductResource::make($this->product)),
        ];
    }
}
