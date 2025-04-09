<?php

namespace App\Http\Requests\Site;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Site\SiteClassificationEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpsertSiteRequest extends TimestampRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $companyIdRule = [];
        if ($this->checkStoreRequest()) {
            $companyIdRule = ['company_id' => ['required', 'numeric', Rule::exists('organization_companies', 'id')]];
        }
        return [
            ...parent::rules(),
            ...$companyIdRule,
            'code' => 'nullable|string|max:20',
            'long_name' => 'required|string|min:1|max:100',
            'short_name' => 'nullable|string|max:100',
            'kana' => 'nullable|string|max:100',
            'start_date' => 'date|nullable|max:10',
            'end_date' => 'date|nullable|max:10|after_or_equal:start_date',
            'site_classification' => Rule::in(SiteClassificationEnum::getValues()),
            'previous_name' => 'nullable|string|max:100|min:1',
            'previous_name_flg' => ['required', Rule::in(PreviousNameFlagEnum::getValues())],
            'en_notation' => 'nullable|string|max:100',
            'post_code' => 'nullable|string|max:20|min:1',
            'address_1' => 'nullable|string|max:100|min:1',
            'address_2' => 'nullable|string|max:100|min:1',
            'address_3' => 'nullable|string|max:100|min:1',
            'phone' => 'nullable|string|max:20|min:1',
            'area_name' => 'nullable|string|max:100',
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.site.code'),
            'long_name' => __('attributes.site.long_name'),
            'short_name' => __('attributes.site.short_name'),
            'kana' => __('attributes.site.kana'),
            'start_date' => __('attributes.site.start_date'),
            'end_date' => __('attributes.site.end_date'),
            'represent_flg' => __('attributes.site.represent_flg'),
            'site_classification' => __('attributes.site.site_classification'),
            'previous_name' => __('attributes.site.previous_name'),
            'previous_name_flg' => __('attributes.site.previous_name_flg'),
            'en_notation' => __('attributes.site.en_notation'),
            'post_code' => __('attributes.site.post_code'),
            'address_1' => __('attributes.site.address_1'),
            'address_2' => __('attributes.site.address_2'),
            'address_3' => __('attributes.site.address_3'),
            'phone' => __('attributes.site.phone'),
            'area_name' => __('attributes.site.area_name'),
            'memo' => __('attributes.site.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification')
        ];
    }
}

