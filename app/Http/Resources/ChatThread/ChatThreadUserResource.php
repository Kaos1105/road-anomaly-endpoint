<?php

namespace App\Http\Resources\ChatThread;

use App\Models\ChatThread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ChatThread
 */
class ChatThreadUserResource extends JsonResource
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
            'creator_id' => $this->creator_id,
            'unread_chat_count' => $this->whenLoaded('chatNotifications', fn() => $this->chatNotifications->count())
        ];
    }
}
