<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\SocialData\PreviousSocialData;
use App\Http\Resources\Transfer\EmployeeTransferItemResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Customer
 */
class RegistrableCustomerResource extends JsonResource
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
            'display_transfer_id' => $this->display_transfer_id,
            'display_transfer' => $this->whenLoaded('displayTransfer', fn() => EmployeeTransferItemResource::make($this->displayTransfer)),
            'responsible_employee' => $this->whenLoaded('responsibleEmployee', fn() => EmployeeNameResource::make($this->responsibleEmployee)),
            'category_name' => $this->category_name,
            'accounting_company' => $this->accounting_company,
            'previous_social_data' => $this->whenLoaded('socialData', fn() => PreviousSocialData::collection($this->socialData)),
        ];
    }
}
