<?php

namespace App\Http\Resources\Company;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 * @property string $site_previous_name_flg
 * @property string $site_long_name
 * @property string $site_previous_name
 * @property string $site_phone
 * @property string $site_address_1
 * @property string $site_address_2
 * @property string $site_address_3
 * @property int count_favorites
 * @property int site_id
 */
class CompanyItemResource extends JsonResource
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
            'site_id' => $this->site_id,
            'representative_site' => $this->whenLoaded('sites', fn() => SiteRelatedResource::make($this->sites->first())),
            'company_classification' => $this->company_classification,
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
