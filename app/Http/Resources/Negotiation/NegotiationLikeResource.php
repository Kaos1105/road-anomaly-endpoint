<?php

namespace App\Http\Resources\Negotiation;

use App\Models\Negotiation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Negotiation
 */
class NegotiationLikeResource extends JsonResource
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
            'like_counter' => $this->like_counter,
        ];
    }
}
