<?php

namespace App\Http\Requests\ChatContent;

use App\Enums\Chat\ChatClassification;
use App\Enums\Chat\ContentClassification;
use App\Enums\Common\DateTimeEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\ChatContent;
use App\Models\ChatThread;
use App\Policies\ChatContentPolicy;
use App\Rules\FileNameRule;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ChatContentInsertRequest extends TimestampRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $now = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);

        $this->merge([
            'employee_id' => \Auth::user()->employee_id,
            'chat_at' => $now,
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $authEmployeeId = \Auth::user()->employee_id;

        $employeeIdRule = ['numeric', 'nullable'];
        if ($this->input('chat_classification') == ChatClassification::USER_CONTENT && !$this->input('chat_thread_id')) {
            $chatThread = ChatThread::where('creator_id', $authEmployeeId)->first();
            if ($chatThread) {
                $employeeIdRule[] = Rule::notIn([$authEmployeeId]);
            }
        }

        return [
            'chat_text' => 'nullable|string',
            'employee_id' => $employeeIdRule,
            'chat_thread_id' => ['numeric',
                Rule::requiredIf(fn() => $this->input('chat_classification') == ChatClassification::ADMIN_CONTENT),
                Rule::exists(ChatThread::class, 'id')],
            'chat_classification' => ['numeric', 'required', Rule::in(ChatClassification::getValues())],
            'chat_at' => 'string|nullable',
            'attachment_files' => ['nullable', 'array', 'min:0', 'max:5'],
            'attachment_files.*' => ['nullable', 'file', new FileNameRule()]
        ];
    }

    //TODO: implement later
    public function attributes(): array
    {
        return [
            'chat_text' => __('attributes.chat_content.chat_text'),
            'employee_id' => __('attributes.chat_content.employee_id'),
            'chat_classification' => __('attributes.chat_content.chat_classification'),
            'content_classification' => __('attributes.chat_content.content_classification'),
        ];
    }
}
