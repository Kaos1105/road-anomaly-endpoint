<?php

namespace App\Http\Requests\Company;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Http\Requests\TimestampRequest;
use App\Repositories\Company\CompanyRepository;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpsertCompanyRequest extends TimestampRequest
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

        $companyClassification = Arr::where(CompanyClassificationEnum::getValues(), fn(int $value) => $value !== CompanyClassificationEnum::SHINNICHIRO);
        $shinnichiro = CompanyRepository::checkExistShinichiro();
        if (!$shinnichiro) {
            $companyClassification = CompanyClassificationEnum::getValues();
        }

        $this->checkStoreRequest();
        $startDateRule = ['nullable', 'date', 'max:10'];
        $endDateRule = ['nullable', 'date', 'max:10'];
        if ($this->request->get('start_date') && $this->request->get('end_date')) {
            $startDateRule = [...$startDateRule, 'before_or_equal:end_date'];
            $endDateRule = [...$endDateRule, 'after_or_equal:start_date'];
        }
        return [
            ...parent::rules(),
            'code' => 'nullable|string|max:20',
            'long_name' => 'required|string|min:1|max:100',
            'short_name' => 'nullable|string|max:100',
            'kana' => 'nullable|string|max:100',
            'start_date' => $startDateRule,
            'end_date' => $endDateRule,
            'group_name' => 'nullable|string|max:100',
            'previous_name' => 'nullable|string|max:100',
            'previous_name_flg' => Rule::in(PreviousNameFlagEnum::getValues()),
            'en_notation' => 'nullable|string|max:100',
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
            'company_classification' => request('company')?->company_classification == CompanyClassificationEnum::SHINNICHIRO
                ? Rule::in(CompanyClassificationEnum::getValues()) : Rule::in($companyClassification),
        ];

    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.company.code'),
            'long_name' => __('attributes.company.long_name'),
            'short_name' => __('attributes.company.short_name'),
            'kana' => __('attributes.company.kana'),
            'start_date' => __('attributes.company.start_date'),
            'end_date' => __('attributes.company.end_date'),
            'group_name' => __('attributes.company.group_name'),
            'previous_name' => __('attributes.company.previous_name'),
            'previous_name_flg' => __('attributes.company.previous_name_flg'),
            'en_notation' => __('attributes.company.en_notation'),
            'memo' => __('attributes.company.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification'),
            'company_classification' => __('attributes.company.company_classification'),
        ];
    }
}
