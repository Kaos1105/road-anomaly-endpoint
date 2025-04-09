<?php

namespace App\Http\Resources\Display;

use App\Http\Resources\System\SystemRelationResource;
use App\Models\Display;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Display
 */
class DisplayRelatedResource extends JsonResource
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
            'system_id' => $this->system_id,
            'system' => $this->whenLoaded('system', fn() => SystemRelationResource::make($this->system)),
            'code' => $this->code,
            'name' => $this->name,
            'use_classification' => $this->use_classification,
        ];
    }
}
