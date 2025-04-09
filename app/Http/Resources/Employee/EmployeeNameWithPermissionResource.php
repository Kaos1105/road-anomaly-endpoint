<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AccessPermission\PermissionInfoResource;
use App\Models\Employee;
use Illuminate\Http\Request;

/**
 * Transform the resource into an array.
 *
 * @mixin   Employee
 */
class EmployeeNameWithPermissionResource extends EmployeeNameResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'access_permission' => PermissionInfoResource::make($this->accessPermissions?->first())
        ];
    }
}
