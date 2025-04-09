<?php

namespace App\Http\Resources\AttachmentFile;

use App\Models\AttachmentFile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttachmentCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attachment_files' => $this->collection->map(function (AttachmentFile $attachmentFile) {
                return new AttachmentFileResource($attachmentFile, 8 * 60);
            }),
        ];
    }
}
