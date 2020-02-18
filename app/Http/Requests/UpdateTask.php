<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTask extends FormRequest
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
            'order_id'=>'required|integer',
            'subject'=>'required|string|max:200',
            'title'=>'required|string|max:200',
            'country'=>'required|string|max:200',
            'reference_style'=>'required|string|max:200',
            'reference_number'=>'required|integer',
            'dead_line'=>'required',
            'upload_time'=>'nullable',
            'deliverable'=>'nullable|string|max:1000',
            'word_count'=>'required|integer',
            'word_distribution'=>'required|string|max:200',
            'case_study'=>'required|string|max:200',
            'user_id'=>'required|integer',
            'description'=>'nullable|string|max:1000',
        ];
    }
}
