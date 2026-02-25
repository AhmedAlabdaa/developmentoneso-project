<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmIncidentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date'          => 'required|date',
            'am_movment_id' => 'required|exists:am_contract_movments,id',
            'note'          => 'nullable|string',
            'status'        => 'required|integer|in:2,3,4', // RanAway, Cancelled, Hold
            'action'        => 'nullable|integer|in:1,2,3,4', // Uses AmReturnAction enum values
        ];
    }
}
