<?php

namespace App\Http\Resources\Customer;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Employee\EmployeeNameWithPermissionResource;
use App\Http\Resources\Transfer\TransferItemByEmployeeResource;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Customer
 */
class CustomerItemResource extends JsonResource
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
            'display_transfer' => $this->whenLoaded('displayTransfer', fn() => TransferItemByEmployeeResource::make($this->displayTransfer)),
            'responsible_employee' => $this->whenLoaded('responsibleEmployee', fn() => EmployeeNameWithPermissionResource::make($this->responsibleEmployee)),
            'category_name' => $this->category_name,
            'accounting_company' => $this->accounting_company,
            'accounting_department_id' => $this->accounting_department_id,
            'accounting_department' => $this->whenLoaded('accountingDepartment', fn() => DepartmentRelatedResource::make($this->accountingDepartment)),
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
