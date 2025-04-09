<?php

namespace App\Http\Resources\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
class EmployeeDeliveryInfoResource extends JsonResource
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
            'post_code' => $this->post_code,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'address_3' => $this->address_3,
            'phone' => $this->phone,
        ];
    }
}
