<?php

namespace Quizviran\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'name' => ['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'وارد کردن نام موضوع الزامی است.',
            'name.string' => 'موضوع وارد شده باید از جنس رشته باشد.',
        ];
    }
}
