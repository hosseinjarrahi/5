<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'type' => 'required|string',
            'phone' => 'required|string',
            'name' => 'required|string',
            'password' => 'required|string|max:36|min:8',
            'confirm' => 'required|string|same:password',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'وارد کردن نوع کاربر الزامی است',
            'phone.required'  => 'وارد کردن تلفن همراه و یا ایمیل الزامی است',
            'name.required'  => 'وارد کردن نام و نام خانوادگی الزامی است',
            'password.required'  => 'وارد کردن رمز الزامی است',
            'confirm.required'  => 'وارد کردن تکرار رمز الزامی است',
            'confirm.same'  => 'رمز با تکرارش برابر نیست',
            'handle.unique' => 'نام کاربری وارد شده قبلا ثبت شده است',
            'phone.unique'  => 'تلفن همراه وارد شده قبلا ثبت شده است',
            'password.min'  => 'رمز حداقل باید 8 کاراکتر باشد',
        ];
    }
}
