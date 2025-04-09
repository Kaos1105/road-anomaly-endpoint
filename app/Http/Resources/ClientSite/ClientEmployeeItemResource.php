<?php

namespace App\Http\Resources\ClientSite;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\ManagementDepartment\MyCompanyEmployee\EmployeeTransfersResource;
use App\Models\ClientEmployee;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ClientEmployee
 */
class ClientEmployeeItemResource extends JsonResource
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
            'role' => $this->role,
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
            'employee' => EmployeeTransfersResource::make($this->employee),
        ];
    }
}
