<?php

namespace App\Http\Requests\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class UpsertAnswerTextRequest extends FormRequest
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
        $answerText = request('answer_text');
        $contentRule = ['required'];
        if (!$answerText) {
            $contentRule = ['nullable'];
        }
        return [
            'answer_content' => [...$contentRule, 'string', 'min:1']
        ];
    }

    public function attributes(): array
    {
        return [
            'answer_content' => __('attributes.answer.answer_content'),
        ];
    }
}
