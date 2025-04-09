<?php

namespace App\Http\Resources\ClientSite;

use App\Http\Resources\Site\SiteSupplierResource;
use App\Models\ClientSite;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ClientSite
 */
class ClientSiteDropdownResource extends JsonResource
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
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
            'management_department_id' => $this->management_department_id,
            'site_id' => $this->site_id,
            'site' => $this->whenLoaded('site', fn() => SiteSupplierResource::make($this->site)),
        ];
    }
}
