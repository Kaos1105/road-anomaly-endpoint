<?php

namespace App\Http\Resources\Group;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Employee\ChatEmployeeResource;
use App\Models\Employee;
use App\Models\Group;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Group
 */
class GroupItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isMember = $this->relationLoaded('employees') && $this->employees->contains(function (Employee $employee) {
                return $employee->id == Auth::user()->employee_id;
            });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'number_of_employees' => $this->group_employees_count,
            'created_by' => $this->created_by,
            'is_member' => $isMember,
            'created_info' => $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]),
            'updated_info' => $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]),
            'employees' => $this->whenLoaded('employees', fn() => ChatEmployeeResource::collection($this->employees))
        ];
    }
}
