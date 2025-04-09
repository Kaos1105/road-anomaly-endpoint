<?php

namespace App\Http\Resources\ChatThread;

use App\Enums\Chat\ChatClassification;
use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\ChatContent\ChatContentAdminResource;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\ChatNotification;
use App\Models\ChatThread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

/**
 * @mixin ChatThread
 * @property string last_chat_at
 */
class ChatThreadNotifyResource extends JsonResource
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
        $notifications = $this->relationLoaded('chatNotifications') ? $this->chatNotifications : collect();
        $unreadChatNotifications = $notifications->filter(function (ChatNotification $notification) {
            $chatContent = $notification->chatContent;
            $isContentNotByAdmin = $chatContent->chat_classification === ChatClassification::ADMIN_CONTENT
                && $chatContent->employee_id !== $this->adminEmployeeId;

            $isUserContent = $chatContent->chat_classification === ChatClassification::USER_CONTENT;
            $isBelongToAdmin = $notification->employee_id === $this->adminEmployeeId;

            return ($isContentNotByAdmin || $isUserContent) && $isBelongToAdmin;
        });

        $lastChatContent = $this->when('chatContents', function () {
            return $this->chatContents->first() ? ChatContentAdminResource::make($this->chatContents->first())->toArray(request()) : null;
        });

        return [
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'admin_employee_id' => $this->adminEmployeeId,
            'creator' => $this->whenLoaded('creator', fn() => EmployeeNameResource::make($this->creator)->toArray($request)),
            'last_chat_content' => $lastChatContent,
            'last_chat_at' => DateTimeHelper::formatDateTime($this->last_chat_at, DateTimeEnum::DATE_TIME_FORMAT),
            'unread_chat_count' => $unreadChatNotifications->count()
        ];
    }
}
