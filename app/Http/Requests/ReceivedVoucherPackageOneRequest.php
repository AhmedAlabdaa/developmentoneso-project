<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceivedVoucherPackageOneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => 'required|integer|exists:invoices,invoice_id',
            'customer_id' => 'required|integer|exists:crm,id',
            'debit_ledger_id' => 'required|integer|exists:ledger_of_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'method_mode' => 'nullable|integer',
            'note' => 'nullable|string|max:500',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function bodyParameters(): array
    {
        return [
            'invoice_id' => [
                'description' => 'The ID of the Invoice to link the receipt voucher to (source).',
                'example' => 1,
            ],
            'customer_id' => [
                'description' => 'The customer ID from CRM. The service will find the associated ledger account (credit side).',
                'example' => 5,
            ],
            'debit_ledger_id' => [
                'description' => 'The debit ledger account ID for the receipt voucher (e.g., Cash/Bank).',
                'example' => 2,
            ],
            'amount' => [
                'description' => 'Amount received from customer.',
                'example' => 500.00,
            ],
            'method_mode' => [
                'description' => 'Payment method mode (optional).',
                'example' => 1,
            ],
            'note' => [
                'description' => 'Note for the receipt voucher (optional).',
                'example' => 'Payment received for Package One',
            ],
        ];
    }
}
