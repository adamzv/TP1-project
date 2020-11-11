<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest
 *
 * @author lacal,angelovicD
 */
class StoreUserRequest extends FormRequest
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
            'name'=>'required|varchar|max:255',
            'email'=>'required|varchar|max:255',
            'password'=>'required|varchar|max255',
            'id.role'=>'required|int',
            //
        ];
    }
    public function messages()
    {
        return[
            'user.name'=>'Invalid user name',
        ];
    }
}
