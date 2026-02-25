<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAmp3ActionNotifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'am_contract_movement_id' => 'sometimes|integer|exists:am_contract_movments,id',
            'amount' => 'sometimes|numeric|min:0',
            'note' => 'nullable|string',
            'refund_date' => 'nullable|date',
            'status' => 'sometimes|integer|in:0,1,2',
        ];
    }
}
