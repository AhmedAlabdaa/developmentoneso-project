<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            $data['ended_date'] = Carbon::parse($this->ended_date)->format('Y-m-d');
        }

        // Normalize installment dates
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
}
