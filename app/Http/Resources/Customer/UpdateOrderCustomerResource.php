<?php

namespace App\Http\Resources\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Customer
 */
class UpdateOrderCustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_name' => $this->category_name,
            'accounting_company' => $this->accounting_company,
            'update_order' => $this->update_order,
            'employee_id' => $this->employee_id,
            'responsible_id' => $this->responsible_id,
            'address_printing_1' => $this->address_printing_1,
            'address_printing_2' => $this->address_printing_2,
            'address_printing_3' => $this->address_printing_3,
            'address_printing_4' => $this->address_printing_4,
            'address_printing_5' => $this->address_printing_5,
            'address_printing_6' => $this->address_printing_6,
            'address_printing_7' => $this->address_printing_7,
        ];
    }
}
