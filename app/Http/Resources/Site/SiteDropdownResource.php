<?php

namespace App\Http\Resources\Site;

use App\Models\Site;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Site
 */
class SiteDropdownResource extends JsonResource
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
            'long_name' => $this->long_name,
            'previous_name' => $this->previous_name,
            'previous_name_flg' => $this->previous_name_flg,
        ];
    }
}
