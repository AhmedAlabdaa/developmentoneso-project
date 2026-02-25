<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreInvoiceServiceRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:invoice_services,name',
            'code' => 'required|string|max:255|unique:invoice_services,code',
            'note' => 'nullable|string|max:1000',
            'status' => 'boolean',
            'type' => 'required|integer|in:1,2,3',
            'settings' => 'nullable|array',
            
            // Nested lines validation
            'lines' => 'nullable|array',
            'lines.*.ledger_account_id' => 'required|integer|exists:ledger_of_accounts,id',
            'lines.*.amount_debit' => 'nullable|numeric|min:0',
            'lines.*.amount_credit' => 'nullable|numeric|min:0',
            'lines.*.vatable' => 'boolean',
            'lines.*.note' => 'nullable|string|max:255',
            'lines.*.source_amount' => 'required|integer|in:1,2',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $lines = $this->input('lines', []);
            
            foreach ($lines as $index => $line) {
                $debit = floatval($line['amount_debit'] ?? 0);
                $credit = floatval($line['amount_credit'] ?? 0);
                
                if ($debit > 0 && $credit > 0) {
                    $validator->errors()->add(
                        "lines.{$index}.amount_debit",
                        'A line cannot have both debit and credit. One must be zero.'
                    );
                }
            }
        });
    }
}

