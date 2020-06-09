<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUser extends FormRequest
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
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'full_name' => 'required|string|max:205',
            'username' => 'required|string|max:100,unique:users',
            'pictur' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ];
       
    }
    public function messages()
    {
        return [
            'first_name.required' => 'First name  is required',
            'first_name.max' => 'First name should not be more than 100 character',
            'first_name.string' => 'First name  is string',
            'last_name.required' => 'last name  is required',
            'last_name.max' => 'last name should not be more than 100 character',
            'last_name.string' => 'last name  is string',
            'full_name.required' => 'full name  is required',
            'full_name.max' => 'full name should not be more than 200 character',
            'full_name.string' => 'full name  is string',
            'username.required' => 'username is required',
            'username.unique' => 'this username already exists',
            'username.string' => 'username is string',
            'username.max' => 'username should not be more than 100 character',
            'pictur.mimes' => 'you should upload jpeg,jpg,png,gif images',
            'pictur.max' => 'image size should be 1 megabyte or less'
           
          
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => false
        ], 400));
    }
}
