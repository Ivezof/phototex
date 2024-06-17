<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:5|regex:/^[а-яА-ЯёЁ\s]/i',
            'login' => 'required|min:5|unique:users,login|regex:/^[a-zA-Z0-9]/i',
            'password' => 'required|min:5|confirmed'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения',
            'name.min' => 'Поле "Имя" должно содержать не менее 5 символов',
            'name.regex' => 'Поле "Имя" может содержать только кирилицу',
            'login.required' => 'Поле "Логин" обязательно для заполнения',
            'login.regex' => 'Поле "Логин" может содержать только латиницу',
            'login.unique' => 'Поле "Логин" не уникально',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.min' => 'Поле "Пароль" должно быть больше 5 символов',
            'password.confirmed'=> "Пароли не совпадают"
        ];
    }
}
