<?php

namespace App\Http\Requests\FAQ;

use App\Enums\FAQ\AnswerTypeEnum;
use App\Rules\AnswerExistsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDisplayOrderAnswersRequest extends FormRequest
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
        return [
            'answer_start.type_answer' => ['required', Rule::in(AnswerTypeEnum::getValues())],
            'answer_start.display_order' => 'required|numeric',
            'answer_start' => new AnswerExistsRule(),
            'answer_end.display_order' => 'required|numeric',
            'answer_end.type_answer' => ['required', Rule::in(AnswerTypeEnum::getValues())],
            'answer_end' => new AnswerExistsRule(),
        ];
    }

    public function attributes(): array
    {
        return [
            'answer_start.type_answer' => __('attributes.answer.answer'),
            'answer_end.type_answer' => __('attributes.answer.answer'),
            'answer_start.display_order' => __('attributes.common.display_order'),
            'answer_end.display_order' => __('attributes.common.display_order'),
        ];
    }
}
