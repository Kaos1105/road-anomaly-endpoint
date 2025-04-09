<?php

namespace App\Http\Resources\Department;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Department
 */
class DepartmentRelatedResource extends JsonResource
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
            'site_id' => $this->site_id,
            'code' => $this->code,
            'long_name' => $this->long_name,
            'short_name' => $this->short_name,
            'previous_name' => $this->previous_name,
            'previous_name_flg' => $this->previous_name_flg,
            'use_classification' => $this->use_classification,
        ];
    }
}
