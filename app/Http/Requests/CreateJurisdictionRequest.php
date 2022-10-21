<?php

namespace App\Http\Requests;

use App\Models\Boundary;
use App\Models\Jurisdiction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class CreateJurisdictionRequest extends FormRequest
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
        $boundary = Boundary::where('boundary_uid', $this->boundary_uid)->first();

        return [
            'name' => [
                'required',
                Rule::unique('jurisdictions')->where('boundary_uid', $this->boundary_uid),
            ],

            'boundary_uid' => [
                'required',
                Rule::exists('boundaries'),
            ],

            'parent_uid' => [
                'nullable',
                Rule::exists('jurisdictions', 'jurisdiction_uid'),
                Rule::requiredIf(fn () => $boundary->level !== 1),
                function ($attribute, $value, $fail) use($boundary) {
                    $parent = Jurisdiction::with('boundary')->where('jurisdiction_uid', $value)->first();

                    if ((int) $boundary->level === 1) {
                        $fail('A top level boundary cannot have a parent');
                    }

                    if ((int) $boundary->level - (int) $parent->boundary->level !== 1) {
                        $fail('A parent should be one level above jurisdiction');
                    }
                }
            ],
        ];
    }
}
