<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\TypingTranGovInv;

class ReceiveTypingInvoicePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'credit_ledger_id' => ['required', 'integer', 'exists:ledger_of_accounts,id'],
            'debit_ledger_id' => ['required', 'integer', 'exists:ledger_of_accounts,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'attachments' => ['nullable', 'array'],
            'status' => ['nullable', Rule::in(['draft', 'posted', 'void'])],
            'payment_mode' => ['nullable', 'integer'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Get the invoice ID from the route parameter
            $invoiceId = $this->route('id');
            $invoice = TypingTranGovInv::find($invoiceId);

            if ($invoice) {
                $currentReceived = $invoice->amount_received ?? 0;
                $invoiceAmount = $invoice->amount_of_invoice ?? 0;
                $newPayment = $this->input('amount', 0);
                
                // Calculate remaining balance
                $remainingBalance = $invoiceAmount - $currentReceived;
                
                // Check if new payment exceeds remaining balance
                if ($newPayment > $remainingBalance) {
                    $validator->errors()->add('amount', 
                        "Payment amount ({$newPayment}) exceeds the remaining invoice balance ({$remainingBalance}). " .
                        "Invoice total: {$invoiceAmount}, Already received: {$currentReceived}"
                    );
                }

                // Also check if invoice is already fully paid
                if ($remainingBalance <= 0) {
                    $validator->errors()->add('amount', 
                        "This invoice has already been fully paid. " .
                        "Invoice total: {$invoiceAmount}, Already received: {$currentReceived}"
                    );
                }
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'amount.required' => 'The payment amount is required.',
            'amount.numeric' => 'The payment amount must be a number.',
            'amount.min' => 'The payment amount must be greater than or equal to 0.',
            'credit_ledger_id.required' => 'The credit ledger account is required.',
            'credit_ledger_id.exists' => 'The selected credit ledger account does not exist.',
            'debit_ledger_id.required' => 'The debit ledger account is required.',
            'debit_ledger_id.exists' => 'The selected debit ledger account does not exist.',
        ];
    }
}
