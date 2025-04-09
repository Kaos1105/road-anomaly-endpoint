<?php

namespace App\Http\Resources\SocialData;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   Workflow
 */
class OrderDateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'execution_at' => DateTimeHelper::formatDateTime($this->execution_at, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
