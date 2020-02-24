<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEscalation extends FormRequest
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
            'task_id' => 'required|integer',
            'escalation_count' => 'required|integer',
            'receive_date_time' => 'required|date',
            'student_message' => 'string|max:1000',
            'response_message' => 'nullable|string|max:1000',
            'escalation_upload' => 'nullable|date',
            'not_justified' => 'nullable|boolean'
        ];
    }
}
