<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageOneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => 'required|integer|exists:invoices,invoice_id',
            'cn_number' => 'required|string|max:255',
            'customer_id' => 'required|integer|exists:crm,id',
            'invoice_service_id' => 'nullable|integer|exists:invoice_services,id',
            'amount_received' => 'nullable|numeric|min:0',
            'debit_ledger_id' => 'nullable|integer|exists:ledger_of_accounts,id|required_if:amount_received,>,0',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function bodyParameters(): array
    {
        return [
            'invoice_id' => [
                'description' => 'The ID of the invoice to link the journal entry to.',
                'example' => 1,
            ],
            'cn_number' => [
                'description' => 'The CN Number from the package.',
                'example' => 'CN-2026-001',
            ],
            'customer_id' => [
                'description' => 'The customer ID from CRM. The service will find the associated ledger account.',
                'example' => 5,
            ],
            'invoice_service_id' => [
                'description' => 'The invoice service ID to use. If not provided, uses first active Package One type (type=1) service.',
                'example' => 1,
            ],
            'amount_received' => [
                'description' => 'Amount received from customer. If > 0, creates a receipt voucher.',
                'example' => 500.00,
            ],
            'debit_ledger_id' => [
                'description' => 'The debit ledger account ID for the receipt voucher (e.g., Cash/Bank). Required if amount_received > 0.',
                'example' => 2,
            ],
        ];
    }
}
