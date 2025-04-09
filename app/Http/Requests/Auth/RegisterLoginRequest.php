<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
    }

    public function rules(): array
    {
        return [
            'login_id' => 'required|string|max:255|unique:snet_logins,login_id',
            'employee_id' => 'required|numeric|unique:snet_logins,employee_id',
            'password' => 'required|string|min:8',
        ];
    }
}
