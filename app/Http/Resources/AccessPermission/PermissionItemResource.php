<?php

namespace App\Http\Resources\AccessPermission;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\System\SystemRelationResource;
use App\Models\AccessPermission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin AccessPermission
 */
class PermissionItemResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'system_id' => $this->system_id,
            'permission_1' => $this->permission_1,
            'permission_2' => $this->permission_2,
            'permission_3' => $this->permission_3,
            'permission_4' => $this->permission_4,
            'system' => $this->whenLoaded('system', fn() => SystemRelationResource::make($this->system)),
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
