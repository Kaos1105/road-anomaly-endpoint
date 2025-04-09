<?php

namespace App\Http\Resources\ManagementGroup;

use App\Models\ManagementGroup;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ManagementGroup
 */
class ManagementGroupRelatedResource extends JsonResource
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
            'name' => $this->name,
            'use_classification' => $this->use_classification,
        ];
    }
}
