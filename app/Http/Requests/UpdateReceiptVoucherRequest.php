<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReceiptVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serial_number' => [
                'sometimes', 
                'string', 
                'max:10', 
                Rule::unique('receipt_voucher', 'serial_number')->ignore($this->route('receipt_voucher'))
            ],
            'source_type' => ['nullable', 'string'],
            'source_id' => ['nullable', 'integer'],
            'attachments' => ['nullable', 'array'],
            'status' => ['nullable', Rule::in(['draft', 'posted', 'void'])],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_mode' => ['nullable', 'integer'],
        'candidate_id' => ['nullable', 'integer'],
            'credit_ledger_id' => ['integer', 'exists:ledger_of_accounts,id'],
            'debit_ledger_id' => ['integer', 'exists:ledger_of_accounts,id'],
        ];
    }
}
