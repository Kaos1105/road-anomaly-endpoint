<?php

namespace App\Http\Resources\Display;

use App\Models\Display;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Display
 */
class DisplayItemSystemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'code' => $this->code,
            'system_id' => $this->system_id,
            'name' => $this->name,
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
        ];
    }
}
