<?php

namespace App\Http\Requests;

use App\Rules\NoSpecialChars;
use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
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
            'title' => ['bail', 'required', 'unique:posts', 'max:255', new NoSpecialChars],
            'body' => 'required',
            'sub_title' => 'exclude_unless:title,|required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A :attribute is required',
            'body.required' => 'A :attribute is required',
            'sub_title.required' => 'A :attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'body' => 'Body',
            'sub_title' => 'Sub Title'
        ];
    }
}
