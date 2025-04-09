<?php

namespace App\Http\Resources\Display;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Display\Content\ContentItemResource;
use App\Http\Resources\System\SystemNameItemResource;
use App\Models\Display;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Display
 */
class ScreenNameItemResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'display_classification' => $this->display_classification,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
            'system' => $this->whenLoaded('system', fn() => SystemNameItemResource::make($this->system)),
            'contents' => $this->whenLoaded('contents', fn() => ContentItemResource::collection($this->contents)),
        ];
    }
}
