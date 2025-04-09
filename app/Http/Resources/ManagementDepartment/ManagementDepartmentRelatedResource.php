<?php

namespace App\Http\Resources\ManagementDepartment;

use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Models\ManagementDepartment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ManagementDepartment
 */
class ManagementDepartmentRelatedResource extends JsonResource
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
            'department' => $this->whenLoaded('department', fn() =>DepartmentRelatedResource::make($this->department)),
            'use_classification' => $this->use_classification
        ];
    }
}
