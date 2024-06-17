<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|regex:/^[0-9]/i',
            'login' => 'required|regex:/^[a-zA-Z]/i',
            'password' => 'required|min:5'
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Поле "Код" обязательно для заполнения',
            'code.regex' => 'Поле "Код" может содержать только цифры',
            'login.required' => 'Поле "Логин" обязательно для заполнения',
            'login.regex' => 'Поле "Логин" может содержать только латиницу',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.min' => 'Поле "Пароль" должно содержать не менее 5 символов'
        ];
    }
}
