<?php

namespace App\Http\Requests\FAQ;

use App\Enums\AccessPermission\Permission2FlagEnum;
use App\Enums\AccessPermission\Permission3FlagEnum;
use App\Enums\AccessPermission\Permission4FlagEnum;
use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Question;
use Illuminate\Validation\Rule;

class UpsertQuestionRequest extends TimestampRequest
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
     */
    public function rules(): array
    {
        /**
         * @var Question $question
         */

        $question = request('question');
        $displayRule = [];
        if (!$question) {
            $displayRule['display_id'] = ['required', 'numeric', Rule::exists('snet_displays', 'id')];
        }

        return [
            ...parent::rules(),
            ...$displayRule,
            'code' => 'required|string|max:20',
            'classification' => 'required|string|max:100',
            'title' => 'required|string|max:100',
            'permission_2' => ['numeric', 'required', Rule::in(Permission2FlagEnum::getValues())],
            'permission_3' => ['numeric', 'required', Rule::in(Permission3FlagEnum::getValues())],
            'permission_4' => ['numeric', 'required', Rule::in(Permission4FlagEnum::getValues())],
            'similar_faq_1_id' => ['numeric', 'nullable', Rule::exists('snet_questions', 'id')],
            'similar_faq_2_id' => ['numeric', 'nullable', Rule::exists('snet_questions', 'id')],
            'similar_faq_3_id' => ['numeric', 'nullable', Rule::exists('snet_questions', 'id')],
            'memo' => 'string|nullable',
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'display_id' => __('attributes.question.display_id'),
            'code' => __('attributes.question.code'),
            'classification' => __('attributes.question.classification'),
            'title' => __('attributes.question.title'),
            'permission_2' => __('attributes.question.permission_2'),
            'permission_3' => __('attributes.question.permission_3'),
            'permission_4' => __('attributes.question.permission_4'),
            'similar_faq_1_id' => __('attributes.question.similar_faq_1_id'),
            'similar_faq_2_id' => __('attributes.question.similar_faq_2_id'),
            'similar_faq_3_id' => __('attributes.question.similar_faq_3_id'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
