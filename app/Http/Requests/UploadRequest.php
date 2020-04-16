<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'file' => 'mimes:jpg,gif,png,jpeg,zip,rar,pdf|max:50000'
        ];
    }

    public function messages()
    {
        return [
            'file.mimes' => 'نوع فایل ارسال شده باید از نوع تصویر و یا فایل فشرده باشد.',
            'file.max' => 'حجم فایل شما بیش از حد مجاز است.'
        ];
    }
}
