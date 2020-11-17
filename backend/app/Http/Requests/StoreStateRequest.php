<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreStateRequest
 *
 * @author lacal,angelovicD
 */
class StoreStateRequest extends FormRequest
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
        return ['name' => [
            'required|varchar|max:255',
            Rule::unique('states', 'name')->ignore($this->state)
        ]
        ];
    }
    public function messages()
    {
        return[
            'store.name'=>'Invalid store name',
        ];
    }
}
