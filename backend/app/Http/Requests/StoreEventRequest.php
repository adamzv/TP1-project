<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreEventRequest
 *
 * @author lacal
 */
class StoreEventRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'room' => 'nullable|string|max:255',
            'lecturer' => 'nullable|string|max:255',
            'attendance_limit' => 'required|integer',
            'beginning' => 'required',
            'end' => 'nullable',
            //'id_user' => 'required',
            'id_place' => 'required',
            'id_faculty' => 'required',
            'id_department' => 'nullable'
        ];
    }
}
