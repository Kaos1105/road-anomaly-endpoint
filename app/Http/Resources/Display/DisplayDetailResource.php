<?php

namespace App\Http\Resources\Display;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Display\Content\ContentItemResource;
use App\Http\Resources\System\SystemRelationResource;
use App\Models\Display;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Display
 */
class DisplayDetailResource extends JsonResource
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
            'code' => $this->code,
            'system' => $this->whenLoaded('system', fn() => SystemRelationResource::make($this->system)),
            'system_id' => $this->system_id,
            'name' => $this->name,
            'display_classification' => $this->display_classification,
            'memo' => $this->memo,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'contents' => $this->whenLoaded('contents', fn() => ContentItemResource::collection($this->contents)),
            'created_info' => $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]),
            'updated_info' => $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]),
        ];
    }
}
