<?php

namespace App\Http\Requests\Employee;

use App\Enums\Common\AttachableTypeEnum;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadEmployeeFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'attachable_type' => ['required', 'string', Rule::in(AttachableTypeEnum::getValues())],
            'attachable_id' => ['required', 'numeric'],
            'file_content.*' => ['required', 'file', 'max:100000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'attachable_type' => __('attributes.attachment_files.attachable_type'),
            'attachable_id' => __('attributes.attachment_files.attachable_id'),
            'file_content' => __('attributes.attachment_files.file_content'),
        ];
    }
}
