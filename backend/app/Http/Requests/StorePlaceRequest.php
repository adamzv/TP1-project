<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StorePlaceRequest
 *
 * @author lacal,angelovicD
 */
class StorePlaceRequest extends FormRequest
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
            'name' =>'required|varchar|max:255',
                'id_city' =>'required|int',

        ];
    }
    public function messages()
    {
        return [
            'place.name'=>'Invalid place name',
        ] ;
    }
}
