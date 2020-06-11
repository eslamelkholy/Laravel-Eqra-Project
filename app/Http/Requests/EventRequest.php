<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'name Is Required',
            'description.required' => 'Description Is Required',
            'location.required' => 'Post Body Is Required',
            'start_date.required' => 'Start Date Is Required',
            'end_date.required' => 'End Date Is Required',
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
