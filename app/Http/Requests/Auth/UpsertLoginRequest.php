<?php

namespace App\Http\Requests\Auth;

use App\Enums\AuthenticationHistory\AuthenticationFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Login;
use Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class UpsertLoginRequest extends TimestampRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $mergeData = ['password' => request()->input('password_decrypt')];
        /**
         * @var Login $login
         */
        $login = request('login');
        if ($login) {
            if ($this->input('password_decrypt') && $this->input('password_decrypt') != $login->password_decrypt) {
                $mergeData['password_updated_at'] = Carbon::now();
            }
        } else {
            $mergeData['authen_flag'] = AuthenticationFlagEnum::NOT_IMPLEMENTED;
            $mergeData['password_updated_at'] = Carbon::now();
        }
        $this->merge($mergeData);

    }

    public function rules(): array
    {
        /**
         * @var Login $login
         */
        $login = request('login');
        $rules = [
            ...parent::rules(),
            'login_id' => ['required', 'string', 'max:100', 'unique:snet_logins,login_id'],
            'password_decrypt' => 'required|string|min:5|max:40',
            'password' => 'required|string|min:5|max:40',
            'password_updated_at' => 'nullable',
            'authen_flag' => ['nullable', Rule::in(AuthenticationFlagEnum::getValues())],
        ];

        if (!$login) {
            $rules['employee_id'] = 'required|numeric|unique:snet_logins,employee_id';
        } else {
            $rules['login_id'] = ['required', 'string', 'max:100', Rule::unique('snet_logins', 'login_id')
                ->ignore($login->id)];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'login_id' => __('attributes.login.login_id'),
            'password_decrypt' => __('attributes.login.password_decrypt'),
        ];
    }
}
