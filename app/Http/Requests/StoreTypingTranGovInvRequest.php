<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTypingTranGovInvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gov_dw_no' => ['nullable', 'string', 'max:50'],
            'gov_inv_attachments' => ['nullable', 'array'],
            'maid_id' => ['nullable', 'integer'],
            'amount_received' => ['nullable', 'numeric', 'min:0'],
            'ledger_of_account_id' => ['required', 'integer', 'exists:ledger_of_accounts,id'],
            'services' => ['required', 'array', 'min:1'],
            'services.*.invoice_service_id' => ['required', 'integer', 'exists:invoice_services,id'],
            'services.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'services.*.dw' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * Get the body parameters for Scribe documentation.
     *
     * @return array
     */
    public function bodyParameters(): array
    {
        return [
            'ledger_of_account_id' => [
                'description' => 'Customer ledger account ID. The customer will be debited with (total credits - total debits) from the selected services.',
                'example' => 30,
            ],
            'gov_dw_no' => [
                'description' => 'Government DW number.',
                'example' => 'DW-12345',
            ],
            'maid_id' => [
                'description' => 'Associated maid ID.',
                'example' => 1,
            ],
            'gov_inv_attachments' => [
                'description' => 'Array of attachment file paths or URLs.',
                'example' => [],
            ],
            'amount_received' => [
                'description' => 'Initial amount received (if any).',
                'example' => 0,
            ],
            'services' => [
                'description' => 'Array of services to include in the invoice.',
                'example' => [['invoice_service_id' => 1, 'quantity' => 2, 'dw' => 'DW-001']],
            ],
            'services.*.invoice_service_id' => [
                'description' => 'ID of the invoice service. Service lines use amount_debit and amount_credit for journal entries.',
                'example' => 1,
            ],
            'services.*.quantity' => [
                'description' => 'Quantity multiplier for the service amounts.',
                'example' => 2,
            ],
            'services.*.dw' => [
                'description' => 'DW number for this specific service.',
                'example' => 'DW-001',
            ],
        ];
    }
}

