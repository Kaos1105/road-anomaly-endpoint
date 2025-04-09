<?php

namespace App\Http\Resources\ClientSite\ClientEmployee;

use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\ClientEmployee;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ClientEmployee
 */
class ClientEmployeeDropdownResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'use_classification' => $this->use_classification,
            'employee' => $this->whenLoaded('employee', fn() => EmployeeNameResource::make($this->employee)),
        ];
    }
}
