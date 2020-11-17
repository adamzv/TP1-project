<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StorePictureRequest
 *
 * @author lacal,angelovicD
 */
class StorePictureRequest extends FormRequest
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
            'link' => [
                'required|text',
                Rule::unique('pictures', 'link')->ignore($this->picture)
            ],
            'id_event' => [
                'required|int'
            ]
        ];
    }
    public function messages()
    {
        return [
            'picture.link'=>'Invalid picture link',
        ] ;
    }
}
