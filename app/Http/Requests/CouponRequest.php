<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'coupon' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'requierd' => 'وارد کردن این فیلد الزامی است',
            'string' => 'اطلاعات وارد شده صحیح نمی باشد',
        ];
    }
}
