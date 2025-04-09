<?php

namespace App\Http\Requests\FAQ;

use App\Enums\FAQ\AnswerFileEnum;
use App\Models\AnswerFile;
use App\Rules\FileNameRule;
use Illuminate\Foundation\Http\FormRequest;

class UpsertAnswerFileRequest extends FormRequest
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
         * @var AnswerFile $answerFile
         */

        return [
            'width_size' => 'nullable|numeric|max:' . AnswerFileEnum::WIDTH_DEFAULT,
            'file_content.*' => ['nullable', 'file', new FileNameRule()]
        ];
    }

    public function attributes(): array
    {
        return [
            'width_size' => __('attributes.answer.width_size'),
            'file_content' => __('attributes.answer.file_content'),
        ];
    }
}
