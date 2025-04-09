<?php

namespace App\Http\Resources\CustomerCategory;

use App\Models\CustomerCategory;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CustomerCategory
 */
class CustomerCategoryItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
