<?php

namespace App\Http\Resources\Announcement;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Display\DisplayRelatedResource;
use App\Models\Announcement;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Announcement
 */
class AnnouncementDisplayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'announcement_classification' => $this->announcement_classification,
            'display' => $this->whenLoaded('display', fn() => new DisplayRelatedResource($this->display)),
            'title' => $this->title,
            'content' => $this->content,
            'start_time' => $this->start_time ? DateTimeHelper::formatDateTime($this->start_time, DateTimeEnum::DATE_TIME_FORMAT) : null,
            'end_time' => $this->end_time ? DateTimeHelper::formatDateTime($this->end_time, DateTimeEnum::DATE_TIME_FORMAT) : null,
        ];
    }
}
