<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required',
            'password' => 'min:8|max:32',
            'bio' => 'max:10000',
            'birth' => 'date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'وارد کردن نام الزامی است.',
            'password.min' => 'حداقل تعداد مجاز برای رمز عبور 8 کاراکتر می باشد.',
            'password.max' => 'حداکثر تعداد مجاز برای رمز عبور 32 کاراکتر می باشد.',
            'bio.max' => 'حداکثر تعداد کاراکتر برای درباره من 10000 کاراکتر می باشد.',
            'birth.date' => 'تاریخ تولد به درستی وارد نشده است.',
        ];
    }
}
