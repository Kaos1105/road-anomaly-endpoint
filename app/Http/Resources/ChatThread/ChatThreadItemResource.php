<?php

namespace App\Http\Resources\ChatThread;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\ChatContent\ChatContentItemResource;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\ChatThread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ChatThread
 * @property string last_chat_at
 */
class ChatThreadItemResource extends JsonResource
{
    protected int $adminEmployeeId;

    public function setParams(int $adminEmployeeId): self
    {
        $this->adminEmployeeId = $adminEmployeeId;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'admin_employee_id' => $this->adminEmployeeId,
            'creator' => $this->whenLoaded('creator', fn() => EmployeeNameResource::make($this->creator)->toArray($request)),
            'last_chat_content' => $this->when('chatContents', function () {
                return $this->chatContents->first() ? ChatContentItemResource::make($this->chatContents->first())->toArray(request()) : null;
            }),
            'last_chat_at' => DateTimeHelper::formatDateTime($this->last_chat_at, DateTimeEnum::DATE_TIME_FORMAT),
            'unread_chat_count' => $this->whenLoaded('chatNotifications', fn() => $this->chatNotifications->count())
        ];
    }
}
