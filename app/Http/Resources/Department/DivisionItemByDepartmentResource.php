<?php

namespace App\Http\Resources\Department;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Division
 * @property int count_favorites
 */
class DivisionItemByDepartmentResource extends JsonResource
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
            'has_favorite' => $this->count_favorites > 0 ? FavoriteFlagEnum::FAVORITE : FavoriteFlagEnum::NO_FAVORITE,
            'code' => $this->code,
            'long_name' => $this->long_name,
            'previous_name_flg' => $this->previous_name_flg ,
            'previous_name' => $this->previous_name,
            'division_classification' => $this->division_classification,
            'phone' => $this->phone,
            'represent_flg' => $this->represent_flg,
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
