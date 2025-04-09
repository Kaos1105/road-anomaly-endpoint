<?php

namespace App\Http\Resources\AccessHistory;

use App\Enums\AccessHistory\AccessibleTypeAttributeEnum;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\AccessHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AccessHistory
 */
class AccessItemTopicCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $suffix = $this->accessible_type ? AccessibleTypeAttributeEnum::getValue($this->accessible_type) : null;
        return [
            'id' => $this->id,
            'employee' => $this->whenLoaded('employee', fn() => EmployeeNameResource::make($this->employee)),
            'system_id' => $this->system_id,
            'accessible_type' => $this->accessible_type,
            'accessible_id' => $this->accessible_id,
            'action' => $this->action,
            'message' => $this->message . $suffix,
            'access_at' => $this->access_at,
        ];
    }
}
