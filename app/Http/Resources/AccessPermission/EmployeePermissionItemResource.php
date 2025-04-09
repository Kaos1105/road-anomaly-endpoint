<?php

namespace App\Http\Resources\AccessPermission;

use App\Enums\Common\DateTimeEnum;
use App\Enums\System\OperationFlagEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\System\SystemRelationResource;
use App\Models\AccessPermission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin AccessPermission
 * @property int permission_classification
 */
class EmployeePermissionItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $systemAccessible = $this->relationLoaded('system') && isset($this->system->operation_classification)
            && $this->system->operation_classification == OperationFlagEnum::IN_OPERATION;

        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'system_id' => $this->system_id,
            'permission_1' => $this->permission_1,
            'permission_2' => $this->permission_2,
            'permission_3' => $this->permission_3,
            'permission_4' => $this->permission_4,
            'is_accessible' => (boolean)$this->permission_classification,
            'is_system_operation' => $systemAccessible,
            'system' => $this->whenLoaded('system', fn() => SystemRelationResource::make($this->system)),
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
