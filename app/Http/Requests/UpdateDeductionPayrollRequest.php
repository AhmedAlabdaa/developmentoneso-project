<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeductionPayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deduction_date' => 'nullable|date',
            'employee_id' => 'sometimes|integer|exists:employees,id',
            'payroll_year' => 'sometimes|integer|min:2020|max:2099',
            'payroll_month' => 'sometimes|integer|min:1|max:12',
            'amount_deduction' => 'sometimes|numeric|min:0',
            'amount_allowance' => 'sometimes|numeric|min:0',
            'note' => 'nullable|string',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'employee_id' => [
                'description' => 'Employee ID.',
                'example' => 10,
            ],
            'payroll_year' => [
                'description' => 'Payroll year.',
                'example' => 2026,
            ],
            'payroll_month' => [
                'description' => 'Payroll month (1-12).',
                'example' => 2,
            ],
            'deduction_date' => [
                'description' => 'Optional deduction date.',
                'example' => '2026-02-22',
            ],
            'amount_deduction' => [
                'description' => 'Deduction amount.',
                'example' => 150,
            ],
            'amount_allowance' => [
                'description' => 'Allowance amount.',
                'example' => 50,
            ],
            'note' => [
                'description' => 'Optional note.',
                'example' => 'Updated adjustment',
            ],
        ];
    }
}
