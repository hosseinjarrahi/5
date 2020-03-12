<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeWorkRequest extends FormRequest
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
            'file' => 'required|max:10Mb|mimes:png,jpg,zip,rar',
            'id' => 'required',
        ];
    }
}
