<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class StoreAmMonthlyContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalize date fields to Y-m-d before validation.
     */
    protected function prepareForValidation(): void
    {
        $data = [];

        if ($this->start_date) {
            $data['start_date'] = Carbon::parse($this->start_date)->format('Y-m-d');
        }
        if ($this->ended_date) {
            // Keep the user-provided date so we can validate it is month-end.
            $data['ended_date'] = Carbon::parse($this->ended_date)->format('Y-m-d');
        }

        if ($this->installment && is_array($this->installment)) {
            $installments = $this->installment;
            foreach ($installments as &$inst) {
                if (!empty($inst['date'])) {
                    $inst['date'] = Carbon::parse($inst['date'])->format('Y-m-d');
                }
            }
            $data['installment'] = $installments;
        }

        $this->merge($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'ended_date' => 'nullable|date|after_or_equal:start_date',
            'customer_id' => 'required|exists:crm,id',
            'maid_id' => [
                'required',
                Rule::exists('employees', 'id')->where('inside_status', 1),
            ],

            'installment' => 'required|array',
            'installment.*.date' => 'required|date',
            'installment.*.amount' => 'required|numeric|min:0',
            'installment.*.note' => 'nullable|string',

            'prorate_amount' => 'nullable|numeric|min:0',
            'prorate_days' => 'nullable|integer|min:1|max:30|required_with:prorate_amount',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'maid_id.exists' => 'The maid should be in office.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $startDate = $this->input('start_date');
            $endedDate = $this->input('ended_date');
            $installments = $this->input('installment', []);

            if (empty($endedDate)) {
                return;
            }

            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endedDate);

            if (!$end->isSameDay($end->copy()->endOfMonth())) {
                $validator->errors()->add(
                    'ended_date',
                    'The ended_date must be the last day of the selected month.'
                );
                return;
            }

            // Count months excluding the start month (eg Mar to May => 2).
            $expectedMonths = (($end->year * 12 + $end->month) - ($start->year * 12 + $start->month));
            $installmentCount = is_array($installments) ? count($installments) : 0;

            if ($expectedMonths !== $installmentCount) {
                $validator->errors()->add(
                    'installment',
                    "Installment count must be {$expectedMonths} month(s) based on start_date and ended_date (excluding the start month)."
                );
            }
        });
    }
}
