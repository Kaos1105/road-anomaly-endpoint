<?php

namespace App\Http\Resources\Employee;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Http\Resources\Transfer\EmployeeTransferItemResource;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 * @property int count_favorites
 * @property string transfer_position
 */
class EmployeeItemResource extends JsonResource
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
            'has_favorite' => $this->count_favorites > 0 ? FavoriteFlagEnum::FAVORITE : FavoriteFlagEnum::NO_FAVORITE,
            'code' => $this->code,
            'transfer_position' => $this->transfer_position,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'maiden_name' => $this->maiden_name,
            'previous_name_flg' => $this->previous_name_flg,
            'transfers' => $this->whenLoaded('transfers', fn() => EmployeeTransferItemResource::collection($this->transfers)),
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
