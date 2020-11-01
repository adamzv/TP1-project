<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreRepeatRequest
 *
 * @author lacal
 */
class StoreRepeatRequest extends FormRequest
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
            'repeatUnit' => [
                'required',
                Rule::unique('repeats', 'repeatUnit')->ignore($this->repeat)
            ],
            'repeatNumber' => [
                'required',
                Rule::unique('repeats', 'repeatNumber')->ignore($this->repeat)
            ]
        ];
    }
}
