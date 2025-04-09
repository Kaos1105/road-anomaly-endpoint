<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AttachmentFile\AttachmentFileResource;
use App\Models\AttachmentFile;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
class EmployeeResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'code' => $this->code,
            'attachment_files' => $this->whenLoaded('attachmentFiles', function () {
                return $this->attachmentFiles->map(function (AttachmentFile $attachmentFile) {
                    return new AttachmentFileResource($attachmentFile, 8 * 60);
                });
            }),
        ];
    }
}
