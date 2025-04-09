<?php

namespace App\Http\Resources\Login;

use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Login
 */
class LoginDashboardResource extends JsonResource
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
            'employee' => $this->whenLoaded('employee', fn() => EmployeeNameResource::make($this->employee)),
            'employee_id' => $this->employee_id,
        ];
    }
}
