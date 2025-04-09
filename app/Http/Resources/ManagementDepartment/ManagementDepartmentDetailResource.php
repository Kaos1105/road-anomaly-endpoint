<?php

namespace App\Http\Resources\ManagementDepartment;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Models\ManagementDepartment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ManagementDepartment
 */
class ManagementDepartmentDetailResource extends JsonResource
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
            'department_id' => $this->department_id,
            'department' => $this->whenLoaded('department', fn() => DepartmentRelatedResource::make($this->department)),
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
