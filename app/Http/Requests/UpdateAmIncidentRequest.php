<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAmIncidentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date'   => 'sometimes|date',
            'note'   => 'nullable|string',
            'status' => 'sometimes|integer|in:2,3,4',
            'action' => 'nullable|integer|in:1,2,3,4',
        ];
    }
}
