<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListBoundariesRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $merges = [];

        $levels = array_filter(explode('|', $this->levels));
        if (count($levels) > 0) {
            $merges['levels'] = array_unique($levels);
        }
        
        $this->merge($merges);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'levels' => [
                'sometimes',
                'array',
                'min:1',
                'max:3',
            ],

            'levels.*' => [
                'numeric',
            ],

            'country_uid' => [
                'sometimes',
                Rule::exists('countries'),
            ],
        ];
    }
}
