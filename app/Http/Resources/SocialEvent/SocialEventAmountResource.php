<?php

namespace App\Http\Resources\SocialEvent;

use App\Http\Resources\Supplier\SupplierRelatedResource;
use App\Models\SocialEvent;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SocialEvent
 */
class SocialEventAmountResource extends JsonResource
{
    protected Supplier|null $supplier;

    public function setParams(Supplier|null $supplier): self
    {
        $this->supplier = $supplier;
        return $this;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'event_title' => $this->event_title,
            'event_progress' => $this->event_progress,
            'use_classification' => $this->use_classification,
            'supplier' => $this->supplier ? SupplierRelatedResource::make($this->supplier) : null,
            'total_amount' => $this->whenLoaded('socialData', fn() => $this->socialData->sum('total_amount'), null),
            'total_tax' => $this->whenLoaded('socialData', fn() => $this->socialData->sum('total_tax'), null),
        ];
    }
}
