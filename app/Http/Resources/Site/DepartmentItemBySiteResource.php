<?php

namespace App\Http\Resources\Site;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Department
 * @property int count_favorites
 */
class DepartmentItemBySiteResource extends JsonResource
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
            'long_name' => $this->long_name,
            'previous_name_flg' => $this->previous_name_flg ,
            'previous_name' => $this->previous_name,
            'phone' => $this->phone,
            'department_classification' => $this->department_classification,
            'display_order' => $this->display_order,
            'represent_flg' => $this->represent_flg,
            'use_classification' => $this->use_classification,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
