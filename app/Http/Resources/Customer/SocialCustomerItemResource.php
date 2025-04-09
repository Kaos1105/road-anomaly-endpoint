<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Employee\SocialResponsibleResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Customer
 */
class SocialCustomerItemResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'responsible_id' => $this->responsible_id,
            'responsible_employee' => $this->whenLoaded('responsibleEmployee',
                fn() => SocialResponsibleResource::make($this->responsibleEmployee)),
        ];
    }
}
