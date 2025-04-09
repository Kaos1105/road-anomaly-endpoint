<?php

namespace App\Http\Resources\EventClassification;

use App\Models\EventClassification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin EventClassification
 */
class EventClassificationRelatedResource extends JsonResource
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
            'description' => $this->description,
            'operation_rule' => $this->operation_rule,
            'use_classification' => $this->use_classification,
            'social_criteria' => $this->social_criteria
        ];
    }
}
