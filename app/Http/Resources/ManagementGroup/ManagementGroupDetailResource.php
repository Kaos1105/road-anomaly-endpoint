<?php

namespace App\Http\Resources\ManagementGroup;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\CustomerCategory\CustomerCategoryItemResource;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\SocialEvent\SocialEventAggregationResource;
use App\Models\ManagementGroup;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ManagementGroup
 */
class ManagementGroupDetailResource extends JsonResource
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
            'name' => $this->name,
            'sender_post_code' => $this->sender_post_code,
            'sender_address_1' => $this->sender_address_1,
            'sender_address_2' => $this->sender_address_2,
            'sender_address_3' => $this->sender_address_3,
            'sender_name' => $this->sender_name,
            'contact_point' => $this->contact_point,
            'contact_phone' => $this->contact_phone,
            'preparatory_personnel_info' => $this->whenLoaded('preparatoryPersonnel', fn() => EmployeeNameResource::make($this->preparatoryPersonnel)),
            'applicant_info' => $this->whenLoaded('applicant', fn() => EmployeeNameResource::make($this->applicant)),
            'approver_info' => $this->whenLoaded('approver', fn() => EmployeeNameResource::make($this->approver)),
            'final_decision_maker_info' => $this->whenLoaded('finalDecisionMaker', fn() => EmployeeNameResource::make($this->finalDecisionMaker)),
            'ordering_personnel_info' => $this->whenLoaded('orderingPersonnel', fn() => EmployeeNameResource::make($this->orderingPersonnel)),
            'payment_personnel_info' => $this->whenLoaded('paymentPersonnel', fn() => EmployeeNameResource::make($this->paymentPersonnel)),
            'completion_personnel_info' => $this->whenLoaded('completionPersonnel', fn() => EmployeeNameResource::make($this->completionPersonnel)),
            'categories' => $this->whenLoaded('customerCategories', fn() => CustomerCategoryItemResource::collection($this->customerCategories)),
            'social_events' => $this->whenLoaded('socialEvents', fn() => SocialEventAggregationResource::collection($this->socialEvents)),
            'memo' => $this->memo,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
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
