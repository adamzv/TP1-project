<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
/**
 * Class StoreFacultyRequest
 *
 * @author lacal,angelovicD
 */
class StoreFacultyRequest extends FormRequest
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
        ];
    }
    public function messages()
    {
        return [
            'faculty.name'=>'Invalid faculty name',
        ];
    }
}
