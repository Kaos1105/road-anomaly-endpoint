<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class FileNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value instanceof UploadedFile) {
            $originalName = $value->getClientOriginalName();
            if (empty($originalName)) {
                $fail(__('validation.required', ['attribute' => __('attributes.answer.file_name')]));
            }
        } else {
            $fail(__('validation.required', ['attribute' => __('attributes.answer.file_name')]));
        }
    }
}
