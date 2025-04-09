<?php

namespace App\Http\Resources\ClientSite;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Site\SiteSupplierResource;
use App\Models\ClientSite;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ClientSite
 */
class ClientSiteItemResource extends JsonResource
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
            'management_department_id' => $this->management_department_id,
            'site_id' => $this->site_id,
            'site' => $this->whenLoaded('site', fn() => SiteSupplierResource::make($this->site)),
            'memo' => $this->memo,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'number_of_negotiations' => $this->negotiations_count,
            'number_of_client_employees' => $this->client_employees_count,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
