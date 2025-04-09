<?php

namespace App\Http\Resources\AuthenticationHistory;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\AuthenticationHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AuthenticationHistory
 */
class DashboardHistoryItemResource extends JsonResource
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
            'action' => $this->action,
            'message' => $this->message,
            'authen_at' => DateTimeHelper::formatDateTime($this->authen_at, DateTimeEnum::DATE_TIME_FORMAT),
        ];
    }
}
