<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChargingPackageOneRequest extends FormRequest
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
            'note' => 'nullable|string|max:500',
            'lines' => 'required|array|min:1',
            'lines.*.ledger_id' => 'required|integer|exists:ledger_of_accounts,id',
            'lines.*.amount' => 'required|numeric|min:0.01',
            'lines.*.note' => 'nullable|string|max:255',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function bodyParameters(): array
    {
        return [
            'invoice_id' => [
                'description' => 'The ID of the Invoice to reference as source.',
                'example' => 1,
            ],
            'customer_id' => [
                'description' => 'The customer ID from CRM. The service will find the associated ledger account for the debit side.',
                'example' => 5,
            ],
            'note' => [
                'description' => 'Note for the journal header (optional).',
                'example' => 'Additional charges for services',
            ],
            'lines' => [
                'description' => 'Array of credit ledger lines with ledger_id and amount.',
                'example' => [
                    ['ledger_id' => 10, 'amount' => 100, 'note' => 'Service charge'],
                    ['ledger_id' => 11, 'amount' => 50, 'note' => 'Processing fee'],
                ],
            ],
            'lines.*.ledger_id' => [
                'description' => 'The ledger account ID for the credit side.',
                'example' => 10,
            ],
            'lines.*.amount' => [
                'description' => 'Amount to credit to this ledger.',
                'example' => 100.00,
            ],
            'lines.*.note' => [
                'description' => 'Note for this specific line (optional).',
                'example' => 'Service charge',
            ],
        ];
    }
}
