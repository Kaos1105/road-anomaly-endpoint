<?php

namespace App\Http\Resources\ManagementDepartment\MyCompanyEmployee;

use App\Models\Employee;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
class EmployeeTransfersResource extends JsonResource
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
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'maiden_name' => $this->maiden_name,
            'previous_name_flg' => $this->previous_name_flg,
            'use_classification' => $this->use_classification,
            'transfers' => $this->whenLoaded('transfers', fn() => TransferItemResource::collection($this->transfers)),
        ];
    }
}
