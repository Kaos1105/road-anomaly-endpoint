<?php

namespace App\Http\Resources\Customer;

use App\Enums\Common\DateTimeEnum;
use App\Enums\SocialCustomer\AddressClassificationEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\SocialData\CustomerDetailSocialDataResource;
use App\Http\Resources\Transfer\TransferItemByEmployeeResource;
use App\Models\Customer;
use App\Models\SocialData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Customer
 */
class CustomerDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $shippingInfo = match ($this->address_classification) {
            AddressClassificationEnum::HOME => [
                'post_code' => $this->employee?->post_code,
                'address_1' => $this->employee?->address_1,
                'address_2' => $this->employee?->address_2,
                'address_3' => $this->employee?->address_3,
                'phone' => $this->employee?->phone,
            ],
            AddressClassificationEnum::COMPANY => [
                'post_code' => $this->displayTransfer?->site?->post_code,
                'address_1' => $this->displayTransfer?->site?->address_1,
                'address_2' => $this->displayTransfer?->site?->address_2,
                'address_3' => $this->displayTransfer?->site?->address_3,
                'phone' => $this->displayTransfer?->site?->phone,
            ],
            AddressClassificationEnum::DESIGNATION => [
                'post_code' => $this->specified_post_code,
                'address_1' => $this->specified_address_1,
                'address_2' => $this->specified_address_2,
                'address_3' => $this->specified_address_3,
                'phone' => $this->specified_phone,
            ],
            default => [
                'post_code' => null,
                'address_1' => null,
                'address_2' => null,
                'address_3' => null,
                'phone' => null,
            ],
        };
        return [
            'id' => $this->id,
            'employee' => $this->whenLoaded('employee', fn() => EmployeeNameResource::make($this->employee)),
            'display_transfer_id' => $this->display_transfer_id,
            'display_transfer' => $this->whenLoaded('displayTransfer', fn() => TransferItemByEmployeeResource::make($this->displayTransfer)),
            'responsible_id' => $this->responsible_id,
            'responsible_employee' => $this->whenLoaded('responsibleEmployee', fn() => EmployeeNameResource::make($this->responsibleEmployee)),
            'processing_site' => $this->processing_site,
            'accounting_company' => $this->accounting_company,
            'accounting_department_id' => $this->accounting_department_id,
            'accounting_department' => $this->whenLoaded('accountingDepartment', fn() => DepartmentRelatedResource::make($this->accountingDepartment)),
            'category_name' => $this->category_name,
            'address_printing_1' => (bool)$this->address_printing_1,
            'address_printing_2' => (bool)$this->address_printing_2,
            'address_printing_3' => (bool)$this->address_printing_3,
            'address_printing_4' => (bool)$this->address_printing_4,
            'address_printing_5' => (bool)$this->address_printing_5,
            'address_printing_6' => (bool)$this->address_printing_6,
            'address_printing_7' => (bool)$this->address_printing_7,
            'specified_post_code' => $this->specified_post_code,
            'specified_address_1' => $this->specified_address_1,
            'specified_address_2' => $this->specified_address_2,
            'specified_address_3' => $this->specified_address_3,
            'specified_phone' => $this->specified_phone,
            'address_classification' => $this->address_classification,
            'shipping_info' => $shippingInfo,
            'update_order' => $this->update_order,
            'memo' => $this->memo,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'social_data' => $this->whenLoaded('socialData', fn() => CustomerDetailSocialDataResource::collection($this->socialData->sortByDesc(function (SocialData $item) {
                return $item->socialEvent->planned_start;
            }))),
            'created_info' => $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]),
            'updated_info' => $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]),

        ];
    }
}
