<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	public function rules()
	{
		return [
			'title' => 'required|min:5|max:100',
			'description' => 'required|min:50|max:500',
			'price' => 'required',
			// 'coverImage' => 'required|file|mimes:jpg,jpeg,png,bmp',
		];
	}
	public function messages()
	{
		return [
			'title.required' => 'Book Title Is Required',
			'title.min' => 'Book Title Must Be At least 5 Characters',
			'title.max' => 'Sorry Max Numbers of Characters is 100',
			'description.required' => 'description is required',
			'description.min' => 'Post Body Must Be At least 50 Characters',
			'description.max' => 'Sorry Max Numbers of Characters is 500',
			'price.required' => 'price Is Required',
			// 'coverImage.*.mimes' => 'Only accepts jpg,jpeg,png,bmp are allowed '
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
