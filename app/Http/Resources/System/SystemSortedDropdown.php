<?php

namespace App\Http\Resources\System;

use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin System
 * @property int operation_classification
 */
class SystemSortedDropdown extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
        ];
    }
}
