<?php

namespace App\Http\Resources\Negotiation;

use App\Http\Resources\ClientSite\ClientSiteDropdownResource;
use App\Models\Negotiation;

/**
 * @mixin Negotiation
 */
class NegotiationItemResource extends NegotiationItemClientSiteResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {

        return [
            ...parent::toArray($request),
            'client_site_id' => $this->client_site_id,
            'client_site' => $this->whenLoaded('clientSite', fn() => ClientSiteDropdownResource::make($this->clientSite)),
        ];
    }
}
