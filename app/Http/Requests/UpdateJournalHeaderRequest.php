<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\JournalStatus;
use Illuminate\Validation\Rule;

class UpdateJournalHeaderRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            // Header fields
            'posting_date' => 'sometimes|required|date',
            'status' => ['sometimes', 'required', Rule::in(array_column(JournalStatus::cases(), 'value'))],
            'source_type' => 'nullable|string|max:255',
            'source_id' => 'nullable|integer',
            'pre_src_type' => 'nullable|string|max:255',
            'pre_src_id' => 'nullable|integer',
            'note' => 'nullable|string|max:1000',
            'meta_json' => 'nullable|array',

            // Lines - nested validation
            'lines' => 'sometimes|required|array|min:2',
            'lines.*.id' => 'nullable|integer|exists:journal_tran_lines,id',
            'lines.*.candidate_id' => 'nullable|integer|exists:employees,id',
            'lines.*.ledger_id' => 'required|integer|exists:ledger_of_accounts,id',
            'lines.*.debit' => 'required|numeric|min:0',
            'lines.*.credit' => 'required|numeric|min:0',
            'lines.*.note' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get the body parameters for API documentation.
     *
     * @return array
     */
    public function bodyParameters(): array
    {
        return [
            'posting_date' => [
                'description' => 'The posting date.',
                'example' => '2026-01-08',
            ],
            'status' => [
                'description' => 'The status: 0=Draft, 1=Posted, 2=Void.',
                'example' => 1,
            ],
            'source_type' => [
                'description' => 'Source model type.',
                'example' => 'App\\Models\\Invoice',
            ],
            'source_id' => [
                'description' => 'Source model ID.',
                'example' => 123,
            ],
            'pre_src_type' => [
                'description' => 'Previous source type.',
                'example' => 'App\\Models\\Order',
            ],
            'pre_src_id' => [
                'description' => 'Previous source ID.',
                'example' => 456,
            ],
            'note' => [
                'description' => 'Journal notes.',
                'example' => 'Updated entry',
            ],
            'meta_json' => [
                'description' => 'Additional metadata.',
                'example' => ['reference' => 'PAY-001'],
            ],
            'lines' => [
                'description' => "Array of transaction lines. Include 'id' to update existing lines, omit to create new ones.",
                'example' => [
                    [
                        'id' => 1,
                        'ledger_id' => 1,
                        'debit' => 1500.00,
                        'credit' => 0.00,
                        'note' => 'Updated debit entry',
                        'candidate_id' => null,
                    ],
                    [
                        'ledger_id' => 3,
                        'debit' => 0.00,
                        'credit' => 1500.00,
                        'note' => 'New credit entry',
                        'candidate_id' => null,
                    ],
                ],
            ],
            'lines[].id' => [
                'description' => 'Line ID (include to update existing line).',
                'example' => 1,
            ],
            'lines[].candidate_id' => [
                'description' => 'Employee ID.',
                'example' => 5,
            ],
            'lines[].ledger_id' => [
                'description' => 'Ledger account ID.',
                'example' => 1,
            ],
            'lines[].debit' => [
                'description' => 'Debit amount (use 0 if credit entry).',
                'example' => 1500.00,
            ],
            'lines[].credit' => [
                'description' => 'Credit amount (use 0 if debit entry).',
                'example' => 0.00,
            ],
            'lines[].note' => [
                'description' => 'Line note.',
                'example' => 'Payment received',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $lines = $this->input('lines', []);
            
            if (empty($lines)) {
                return; // Skip validation if lines are not being updated
            }

            // Validate that each line has either debit or credit (not both)
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
