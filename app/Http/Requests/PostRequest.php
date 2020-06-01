<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'body_content' => 'required|min:3|max:250'
        ];
    }
    public function messages(){
        return [
            'body_content.required' => 'Post Body Is Required',
            'body_content.min' => 'Post Body Must Be At least 3 Characters',
            'body_content.max' => 'Sorry Max Numbers of Characters is 250',
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
