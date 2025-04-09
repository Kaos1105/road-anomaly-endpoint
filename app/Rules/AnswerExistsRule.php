<?php

namespace App\Rules;

use App\Enums\FAQ\AnswerTypeEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class AnswerExistsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $table = $value['type_answer'] === AnswerTypeEnum::TEXT
            ? 'snet_answer_texts'
            : 'snet_answer_files';

        if (!DB::table($table)->where('id', $value['id'])->exists()) {
            $fail(__('validation.exists', ['attribute' => __('attributes.answer.answer')]));
        }
    }
}
