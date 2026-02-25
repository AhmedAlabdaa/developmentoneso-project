<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeductionPayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rows' => 'sometimes|array|min:1',
            'rows.*.deduction_date' => 'nullable|date',
            'rows.*.employee_id' => 'required_with:rows|integer|exists:employees,id',
            'rows.*.payroll_year' => 'required_with:rows|integer|min:2020|max:2099',
            'rows.*.payroll_month' => 'required_with:rows|integer|min:1|max:12',
            'rows.*.amount_deduction' => 'nullable|numeric|min:0',
            'rows.*.amount_allowance' => 'nullable|numeric|min:0',
            'rows.*.note' => 'nullable|string',

            'deduction_date' => 'nullable|date',
            'employee_id' => 'required_without:rows|integer|exists:employees,id',
            'payroll_year' => 'required_without:rows|integer|min:2020|max:2099',
            'payroll_month' => 'required_without:rows|integer|min:1|max:12',
            'amount_deduction' => 'nullable|numeric|min:0',
            'amount_allowance' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'employee_id' => [
                'description' => 'Employee ID for single insert (required when rows is not provided).',
                'example' => 10,
            ],
            'payroll_year' => [
                'description' => 'Payroll year for single insert.',
                'example' => 2026,
            ],
            'payroll_month' => [
                'description' => 'Payroll month (1-12) for single insert.',
                'example' => 2,
            ],
            'deduction_date' => [
                'description' => 'Optional deduction date for single insert.',
                'example' => '2026-02-22',
            ],
            'amount_deduction' => [
                'description' => 'Optional deduction amount for single insert.',
                'example' => 150,
            ],
            'amount_allowance' => [
                'description' => 'Optional allowance amount for single insert.',
                'example' => 50,
            ],
            'note' => [
                'description' => 'Optional note for single insert.',
                'example' => 'Late penalty',
            ],
            'rows' => [
                'description' => 'Bulk payload. When provided, endpoint inserts multiple rows.',
                'example' => [
                    [
                        'employee_id' => 10,
                        'payroll_year' => 2026,
                        'payroll_month' => 2,
                        'deduction_date' => '2026-02-22',
                        'amount_deduction' => 150,
                        'amount_allowance' => 0,
                        'note' => 'Late penalty',
                    ],
                    [
                        'employee_id' => 11,
                        'payroll_year' => 2026,
                        'payroll_month' => 2,
                        'deduction_date' => '2026-02-22',
                        'amount_deduction' => 0,
                        'amount_allowance' => 200,
                        'note' => 'Bonus allowance',
                    ],
                ],
            ],
        ];
    }
}
