<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTypingTranGovInvRequest extends FormRequest
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
            'ledger_of_account_id' => ['sometimes', 'integer', 'exists:ledger_of_accounts,id'],
            'services' => ['sometimes', 'array', 'min:1'],
            'services.*.invoice_service_id' => ['required', 'integer', 'exists:invoice_services,id'],
            'services.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'services.*.dw' => ['nullable', 'string', 'max:50'],
        ];
    }
}
