<?php

namespace App\Http\Resources\Display\Content;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Content
 */
class ContentItemResource extends JsonResource
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
            'display_id' => $this->display_id,
            'no' => $this->no,
            'name' => $this->name,
            'classification' => $this->classification,
            'permission_1' => $this->permission_1,
            'permission_2' => $this->permission_2,
            'permission_3' => $this->permission_3,
            'permission_4' => $this->permission_4,
            'memo' => $this->memo,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
