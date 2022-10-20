<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBoundaryRequest extends FormRequest
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
            'country_uid' => [
                'required',
                Rule::exists('countries'),
            ],

            'name' => [
                'required',
                Rule::unique('boundaries')->where('country_uid', $this->country_uid),
            ],
            
            'level' => [
                'required',
                'numeric',
                Rule::unique('boundaries')->where('country_uid', $this->country_uid),
            ],
        ];
    }
}
