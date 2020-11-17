<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreCityRequest
 *
 * @author lacal,angelovicD
 */
class StoreCityRequest extends FormRequest
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
            'name' => [
                'required|varchar|max:225',
                Rule::unique('cities', 'name')->ignore($this->city)
            ],
            'id_state' => [
                'required|int',
            ]

            ];

    }
    public function messages()
    {
        return [
          'city.name'=>'Invalid city name',
        ];
    }
}
