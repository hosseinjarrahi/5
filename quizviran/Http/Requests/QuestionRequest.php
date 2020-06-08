<?php

namespace Quizviran\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'pic' => 'nullable|base64image|base64mimes:jpg,png,gif,jpeg|base64max:3000kb',
            'A' => 'nullable',
            'B' => 'nullable',
            'C' => 'nullable',
            'D' => 'nullable',
            'answer' => 'nullable',
            'category' => 'nullable',
            'desc' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'pic.base64image' => 'تصویر ارسالی معتبر نمی باشد.',
            'pic.base64mimes' => 'فایل ارسالی حتما باید یک تصویر باشد.',
            'pic.base64max' => ' حجم تصویر باید کمتراز 3 مگابایت باشد.',
        ];
    }
}
