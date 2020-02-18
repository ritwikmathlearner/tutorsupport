<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTutor extends FormRequest
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
            'full_name' => 'bail|required|max:180|min:3',
            'position' => 'bail|required|max:20|min:3',
            'join_date' => 'required',
            'name_on_portal' => 'bail|required|max:150'
        ];
    }
}
