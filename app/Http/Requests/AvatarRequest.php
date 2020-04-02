<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|max:500kb|mimes:jpg,png,jpeg'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'ارسال تصویر الزامی است.',
            'file.max' => 'حجم تصویر ارسالی بیش از حد مجاز است.',
            'file.mimes' => 'فایلی ارسالی باید یک عکس باشد.',
        ];
    }
}
