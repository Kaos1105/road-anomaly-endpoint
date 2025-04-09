<?php

namespace App\Http\Resources\AccessHistory;

use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\System\SystemRelationResource;
use App\Models\AccessHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AccessHistory
 */
class UserSettingHistoryResource extends JsonResource
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
            'employee' => $this->whenLoaded('employee', fn() => EmployeeNameResource::make($this->employee)),
            'system_id' => $this->system_id,
            'system' => $this->whenLoaded('system', fn() => SystemRelationResource::make($this->system)),
            'accessible_type' => $this->accessible_type,
            'accessible_id' => $this->accessible_id,
            'message' => $this->message,
            'access_at' => $this->access_at,
        ];
    }
}
