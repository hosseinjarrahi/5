<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'variable' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'variable.required' => 'وارد کردن ایمیل و یا تلفن همراه الزامی است',
            'password.required' => 'وارد کردن رمز عبور الزامی است',
        ];
    }
}
