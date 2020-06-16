<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatePasswordValidation extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'newPassword' => 'required|max:100'
        ];
    }
     public function messages()
    {
        return [

            'newPassword.required' => 'password is required',
            'newPassword.max' => 'password should not be more than 100 character',
        ];
    }
}
