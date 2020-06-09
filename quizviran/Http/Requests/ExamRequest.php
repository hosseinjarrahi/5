<?php

namespace Quizviran\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'name' => ['required','string'],
            'duration' => ['numeric','required'],
            'desc' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'وارد کردن نام آزمون الزامی است.',
            'duration.required' => 'وارد کردن مدت زمان آزمون الزامی است.',
            'duration.numeric' => 'مدت زمان باید از جنس عدد باشد.',
            'name.string' => 'نام وارد شده باید از نوع رشته باشد.',
        ];
    }
}
