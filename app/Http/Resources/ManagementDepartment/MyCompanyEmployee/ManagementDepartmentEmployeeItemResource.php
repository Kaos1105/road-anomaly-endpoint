<?php

namespace App\Http\Resources\ManagementDepartment\MyCompanyEmployee;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Models\MyCompanyEmployee;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MyCompanyEmployee
 */
class ManagementDepartmentEmployeeItemResource extends JsonResource
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
            'position_classification' => $this->position_classification,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
            'employee' => EmployeeTransfersResource::make($this->employee),
        ];
    }
}
