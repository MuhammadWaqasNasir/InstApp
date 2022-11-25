<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'imgaes_per_page'=>'required||max:20||min:5||numeric',
            'videos_per_page'=>'required||max:10||min:4||numeric',
            'coloums_per_page'=>'required||max:5||min:3||numeric',
            'redirect_link'=>'boolean'
            //
        ];
    }
}
