<?php

namespace App\Http\Resources\ChatContent;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\AttachmentFile\AttachmentFileResource;
use App\Http\Resources\Employee\ChatEmployeeResource;
use App\Models\AttachmentFile;
use App\Models\ChatContent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ChatContent
 */
class ChatContentItemResource extends JsonResource
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
            'chat_thread_id' => $this->chat_thread_id,
            'employee_id' => $this->employee_id,
            'employee' => $this->whenLoaded('employee', fn() => ChatEmployeeResource::make($this->employee)->toArray($request)),
            'chat_classification' => $this->chat_classification,
            'chat_text' => $this->chat_text,
            'chat_at' => DateTimeHelper::formatDateTime($this->chat_at, DateTimeEnum::DATE_TIME_FORMAT),
            'attachment_files' => $this->whenLoaded('attachmentFiles', function () {
                return $this->attachmentFiles->map(function (AttachmentFile $attachmentFile) {
                    return (new AttachmentFileResource($attachmentFile, 8 * 60))->toArray(request());
                })->toArray();
            }),
        ];
    }
}
