<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Employee\EmployeeDeliveryInfoResource;
use App\Http\Resources\Employee\SocialResponsibleResource;
use App\Http\Resources\Transfer\TransferItemByEmployeeResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Customer
 */
class SocialCustomerResource extends JsonResource
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
            'category_name' => $this->category_name,
            'accounting_company' => $this->accounting_company,
            'update_order' => $this->update_order,
            'employee_id' => $this->employee_id,
            'employee' => $this->whenLoaded('employee', fn() => new EmployeeDeliveryInfoResource($this->employee)),
            'major_transfers' => $this->whenLoaded('employee', function () {
                return !$this->employee->relationLoaded('transfers') ? collect([]) :
                    TransferItemByEmployeeResource::collection($this->employee->transfers);
            }),
            'responsible_id' => $this->responsible_id,
            'responsible_employee' => $this->whenLoaded('responsibleEmployee',
                fn() => SocialResponsibleResource::make($this->responsibleEmployee)),
            'address_printing_1' => $this->address_printing_1,
            'address_printing_2' => $this->address_printing_2,
            'address_printing_3' => $this->address_printing_3,
            'address_printing_4' => $this->address_printing_4,
            'address_printing_5' => $this->address_printing_5,
            'address_printing_6' => $this->address_printing_6,
            'address_printing_7' => $this->address_printing_7,
            'specified_post_code' => $this->specified_post_code,
            'specified_address_1' => $this->specified_address_1,
            'specified_address_2' => $this->specified_address_2,
            'specified_address_3' => $this->specified_address_3,
            'specified_phone' => $this->specified_phone,
        ];
    }
}
