<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->request->get('login_id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'login_id' => 'required|string|max:255|unique:users,login_id',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ];
    }
}
