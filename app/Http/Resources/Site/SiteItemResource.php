<?php

namespace App\Http\Resources\Site;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Http\Resources\Company\CompanyRelatedResource;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Site
 * @property int count_favorites
 */
class SiteItemResource extends JsonResource
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
            'kana' => $this->kana,
            'long_name' => $this->long_name,
            'previous_name_flg' => $this->previous_name_flg ,
            'previous_name' => $this->previous_name,
            'phone' => $this->phone,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'address_3' => $this->address_3,
            'site_classification' => $this->site_classification,
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null,
            'company' => $this->whenLoaded('company', fn() => CompanyRelatedResource::make($this->company)),
        ];
    }
}
