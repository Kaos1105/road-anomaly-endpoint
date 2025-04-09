<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AccessPermission\PermissionItemResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   Employee
 */
class EmployeePermissionResource extends JsonResource
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
            'code' => $this->code,
            'access_permission' => $this->whenLoaded('accessPermissions', fn() => PermissionItemResource::make($this->accessPermissions->first())),
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'previous_name_flg' => $this->previous_name_flg,
            'maiden_name' => $this->maiden_name,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
        ];
    }
}
