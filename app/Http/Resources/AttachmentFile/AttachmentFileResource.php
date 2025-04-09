<?php

namespace App\Http\Resources\AttachmentFile;

use App\Helpers\FileHelper;
use App\Models\AttachmentFile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AttachmentFile
 */
class AttachmentFileResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     */
    public function __construct($resource, public ?int $expirationMinutes)
    {
        parent::__construct($resource);
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
            'attachable_id' => $this->attachable_id,
            'attachable_type' => $this->attachable_type,
            'file_name' => $this->file_name,
            'file_path' => FileHelper::temporaryUrl($this->file_path, $this->expirationMinutes),
        ];
    }
}
