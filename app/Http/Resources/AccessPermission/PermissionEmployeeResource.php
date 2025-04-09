<?php

namespace App\Http\Resources\AccessPermission;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\System\OperationFlagEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\System\SystemRelationResource;
use App\Http\Resources\Transfer\EmployeeTransferItemResource;
use App\Models\AccessPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin AccessPermission
 * @property string $access_at
 * @property int permission_classification
 */
class PermissionEmployeeResource extends JsonResource
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
        $employeeAccessible = $this->relationLoaded('employee') && $this->employee->use_classification === UseFlagEnum::USE;

        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'employee' => $this->whenLoaded('employee', fn() => EmployeeNameResource::make($this->employee)),
            'transfer' => $this->whenLoaded('employee', function () {
                if ($this->employee->relationLoaded('transfers')) {
                    return EmployeeTransferItemResource::make($this->employee->transfers->first());
                }
                return null;
            }),
            'is_accessible' => $systemAccessible && $employeeAccessible && $this->permission_classification,
            'system_id' => $this->system_id,
            'system' => $this->whenLoaded('system', fn() => SystemRelationResource::make($this->system)),
            'permission_1' => $this->permission_1,
            'permission_2' => $this->permission_2,
            'permission_3' => $this->permission_3,
            'permission_4' => $this->permission_4,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
            'access_at' => DateTimeHelper::formatDateTime($this->access_at, DateTimeEnum::DATE_TIME_FORMAT),
        ];
    }
}
