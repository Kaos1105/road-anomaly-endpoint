<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AttachmentFile\AttachmentFileResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   Employee
 */
class ChatEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $avatar = $this->relationLoaded('attachmentFiles') ? $this->attachmentFiles->first() : null;

        return [
            'id' => $this->id,
            'code' => $this->code,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'maiden_name' => $this->maiden_name,
            'previous_name_flg' => $this->previous_name_flg,
            'use_classification' => $this->use_classification,
            'avatar' => $avatar ? AttachmentFileResource::make($avatar, null)->toArray($request) : null
        ];
    }
}
