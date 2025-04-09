<?php

namespace App\Http\Resources\ManagementDepartment;

use App\Models\ManagementDepartment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ManagementDepartment
 */
class ManagementDepartmentDropdownResource extends JsonResource
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
            'display_order' => $this->display_order,
        ];
    }
}
