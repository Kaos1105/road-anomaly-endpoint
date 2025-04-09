<?php

namespace App\Http\Resources\Announcement;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Display\DisplayRelatedResource;
use App\Http\Resources\System\SystemRelationResource;
use App\Http\Resources\System\SystemSortedDropdown;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Announcement
 */
class AnnouncementItemResource extends JsonResource
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
            'system_id' => $this->system_id,
            'system' => $this->whenLoaded('system', fn() => new SystemSortedDropdown($this->system)),
            'display' => $this->whenLoaded('display', fn() => new DisplayRelatedResource($this->display)),
            'display_id' => $this->display_id,
            'announcement_classification' => $this->announcement_classification,
            'title' => $this->title,
            'content' => $this->content,
            'start_time' => Carbon::parse($this->start_time)->format(DateTimeEnum::DATE_TIME_FORMAT_WO_SECOND),
            'end_time' => $this->end_time ? Carbon::parse($this->end_time)->format(DateTimeEnum::DATE_TIME_FORMAT_WO_SECOND) : null,
            'use_classification' => $this->use_classification,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
