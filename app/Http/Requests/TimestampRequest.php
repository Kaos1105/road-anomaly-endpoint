<?php

namespace App\Http\Requests;

use App\Enums\Common\DateTimeEnum;
use App\Models\Login;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TimestampRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        /*** @var $login Login
         */
        $login = \Auth::user();

        $now = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);
        if ($this->request->get('en_notation')) {
            $this->merge([
                'en_notation' => json_decode(request()->getContent())->en_notation
            ]);
        }
        $this->merge([
            'updated_at' => $now,
            'updated_by' => $login->employee_id,
        ]);
        if ($this->checkStoreRequest()) {
            $this->merge([
                'created_at' => $now,
                'created_by' => $login->employee_id,
            ]);
        }
    }

    public function checkStoreRequest(): bool
    {
        return Request::isMethod(self::METHOD_POST);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'updated_at' => ['string', 'nullable'],
            'updated_by' => ['numeric', 'nullable'],
            'created_by' => ['numeric', 'nullable'],
            'created_at' => ['string', 'nullable'],
        ];
    }
}
