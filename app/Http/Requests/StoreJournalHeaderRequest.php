<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\JournalStatus;
use Illuminate\Validation\Rule;

class StoreJournalHeaderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'created_by' => \Auth::id() ?? 1,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Header fields
            'posting_date' => 'required|date',
            'status' => ['required', Rule::in(array_column(JournalStatus::cases(), 'value'))],
            'source_type' => 'nullable|string|max:255',
            'source_id' => 'nullable|integer',
            'pre_src_type' => 'nullable|string|max:255',
            'pre_src_id' => 'nullable|integer',
            'note' => 'nullable|string|max:1000',
            'meta_json' => 'nullable|array',
            'created_by' => 'required|integer|exists:users,id',

            // Lines - nested validation
            'lines' => 'required|array|min:2',
            'lines.*.candidate_id' => 'nullable|integer|exists:employees,id',
            'lines.*.ledger_id' => 'required|integer|exists:ledger_of_accounts,id',
            'lines.*.debit' => 'required|numeric|min:0',
            'lines.*.credit' => 'required|numeric|min:0',
            'lines.*.note' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
 
            $lines = $this->input('lines', []);
            
            foreach ($lines as $index => $line) {
                $debit = (float) ($line['debit'] ?? 0);
                $credit = (float) ($line['credit'] ?? 0);

                if ($debit > 0 && $credit > 0) {
                    $validator->errors()->add(
                        "lines.{$index}",
                        "A line cannot have both debit and credit. Please use only one."
                    );
                }

                if ($debit == 0 && $credit == 0) {
                    $validator->errors()->add(
                        "lines.{$index}",
                        "A line must have either a debit or credit value."
                    );
                }
            }

            // Validate that total debits equal total credits
            $totalDebit = array_sum(array_column($lines, 'debit'));
            $totalCredit = array_sum(array_column($lines, 'credit'));

            if (round($totalDebit, 2) != round($totalCredit, 2)) {
                $validator->errors()->add(
                    'lines',
                    "Total debits ({$totalDebit}) must equal total credits ({$totalCredit})."
                );
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'lines.required' => 'Journal must have transaction lines.',
            'lines.min' => 'Journal must have at least 2 transaction lines (double-entry accounting).',
            'lines.*.ledger_id.required' => 'Each line must have a ledger account.',
            'lines.*.ledger_id.exists' => 'The selected ledger account does not exist.',
        ];
    }
}
