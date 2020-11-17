<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class StoreCategoryRequest
 *
 * @author lacal,angelovicD
 */
class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::moderator();
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
                Rule::unique('categories', 'name')->ignore($this->category)]];
    }
    public function messages()
    {
            //
            return[ 'category.name'=> 'Invalid category name.',

    ];

    }
}
