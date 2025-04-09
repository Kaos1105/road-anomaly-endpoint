<?php

namespace App\Http\Resources\ChatThread;

use App\Http\Resources\ChatContent\ChatContentDashboardResource;
use App\Http\Resources\Employee\ChatEmployeeResource;
use App\Models\ChatThread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ChatThread
 */
class UnreadThreadDashboardResource extends JsonResource
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
            'creator' => $this->whenLoaded('creator', fn() => ChatEmployeeResource::make($this->creator)->toArray($request)),
            'number_of_unread_contents' => $this->chat_notifications_count,
            'last_content' => $this->whenLoaded('chatContents', fn() => ChatContentDashboardResource::make($this->chatContents->first()))
        ];
    }
}
