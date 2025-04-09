<?php

namespace App\Http\Resources\AccessHistory;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\System\SystemRelationResource;
use App\Models\AccessHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AccessHistory
 */
class AccessHistoryItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $disableViewAccessibleTypes = [
            AccessibleTypeEnum::CONTENT,
            AccessibleTypeEnum::ATTACHMENT_FILE,
            AccessibleTypeEnum::CHAT_THREAD,
            AccessibleTypeEnum::TRANSFER,
            AccessibleTypeEnum::ACCESS_PERMISSION,
            AccessibleTypeEnum::DEVICE_INFORMATION,
        ];

        return [
            'id' => $this->id,
            'employee' => $this->whenLoaded('employee', fn() => EmployeeNameResource::make($this->employee)),
            'accessible' => (bool)$this->accessible,
            'system_id' => $this->system_id,
            'system' => $this->whenLoaded('system', fn() => SystemRelationResource::make($this->system)),
            'accessible_type' => $this->accessible_type,
            'accessible_id' => (
                in_array($this->accessible_type, $disableViewAccessibleTypes) ||
                ($this->accessible_type === AccessibleTypeEnum::QUESTION && $this->action === AccessActionTypeEnum::USER_VIEW_QUESTION)
            ) ? null : $this->accessible_id,
            'action' => $this->action,
            'result_classification' => $this->result_classification,
            'message' => $this->message,
            'access_at' => $this->access_at,
        ];
    }
}
