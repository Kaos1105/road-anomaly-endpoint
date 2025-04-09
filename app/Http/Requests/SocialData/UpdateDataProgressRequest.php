<?php

namespace App\Http\Requests\SocialData;

use App\Enums\Workflow\ExecutionReceiptEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpdateDataProgressRequest extends TimestampRequest
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
            'data_progress' => ['required', 'numeric', Rule::in(WorkflowOrderEnum::getValues())],
            'comment' => 'string|nullable',
            'execution_type' => ['required', 'numeric', Rule::in(ExecutionReceiptEnum::getValues())],
        ];
    }

    public function attributes(): array
    {
        return [
            'data_progress' => __('attributes.social_data.data_progress'),
            'execution_type' => __('attributes.workflow.execution_type'),
        ];
    }
}
