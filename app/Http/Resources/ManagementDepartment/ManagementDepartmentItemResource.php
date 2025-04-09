<?php

namespace App\Http\Resources\ManagementDepartment;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Models\ManagementDepartment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ManagementDepartment
 */
class ManagementDepartmentItemResource extends JsonResource
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
            'department' => $this->whenLoaded('department', fn() =>DepartmentRelatedResource::make($this->department)),
            'memo' => $this->memo,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
            'number_of_users' => $this->my_company_employees_count
        ];
    }
}
