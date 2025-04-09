<?php

namespace App\Http\Requests\BatchRegistration;

use App\Enums\Excel\ExcelTemplateEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ImportFileRequest extends FormRequest
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
            'file' => [
                'required', File::types([ExcelTemplateEnum::CSV_TYPE, ExcelTemplateEnum::TEXT_FILE]),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'file' => __('attributes.excel.file'),
        ];
    }
}
