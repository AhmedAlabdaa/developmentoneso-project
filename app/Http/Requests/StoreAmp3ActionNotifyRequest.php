<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmp3ActionNotifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'am_contract_movement_id' => 'required|integer|exists:am_contract_movments,id',
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'refund_date' => 'required|date',
        ];
    }
}
