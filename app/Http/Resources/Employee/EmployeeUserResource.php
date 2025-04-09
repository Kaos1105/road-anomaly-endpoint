<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\Login\LoginResource;
use App\Http\Resources\Transfer\EmployeeTransferItemResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   Employee
 */
class EmployeeUserResource extends JsonResource
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
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'maiden_name' => $this->maiden_name,
            'previous_name_flg' => $this->previous_name_flg,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_email' => $this->company_email,
            'company_phone' => $this->company_phone,
            'use_classification' => $this->use_classification,
            'login' => $this->whenLoaded('logins', fn() => new LoginResource($this->logins->first())),
            'transfer' => $this->whenLoaded('transfers', fn() => new EmployeeTransferItemResource($this->transfers->first())),
        ];
    }
}
