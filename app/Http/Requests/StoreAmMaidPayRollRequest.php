<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmMaidPayRollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'year' => 'required|integer|min:2020|max:2099',
            'month' => 'required|integer|min:1|max:12',
            'note' => 'nullable|string',
            'rows' => 'required|array|min:1',
            'rows.*.employee_id' => 'required|integer|exists:employees,id|distinct',
            'rows.*.payment_method' => 'nullable|string|max:20',
            'rows.*.basic_salary' => 'nullable|numeric|min:0',
            'rows.*.deduction' => 'nullable|numeric|min:0',
            'rows.*.allowance' => 'nullable|numeric|min:0',
            'rows.*.net' => 'nullable|numeric|min:0',
            'rows.*.paid_at' => 'nullable|date',
            'rows.*.status' => 'nullable|string|max:20',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'year' => [
                'description' => 'Payroll year applied to all rows.',
                'example' => 2026,
            ],
            'month' => [
                'description' => 'Payroll month (1-12) applied to all rows.',
                'example' => 2,
            ],
            'note' => [
                'description' => 'Optional note applied to all rows.',
                'example' => 'February payroll',
            ],
            'rows' => [
                'description' => 'Bulk rows with per-employee payroll values.',
                'example' => [
                    [
                        'employee_id' => 10,
                        'payment_method' => 'bank',
                        'basic_salary' => 1500,
                        'deduction' => 200,
                        'allowance' => 100,
                        'net' => 1400,
                        'paid_at' => '2026-02-28 10:00:00',
                        'status' => 'paid',
                    ],
                    [
                        'employee_id' => 11,
                        'payment_method' => 'cash',
                        'basic_salary' => 1800,
                        'deduction' => 50,
                        'allowance' => 0,
                        'net' => 1750,
                        'paid_at' => '2026-02-28 10:00:00',
                        'status' => 'paid',
                    ],
                ],
            ],
            'rows.*.employee_id' => [
                'description' => 'Employee ID.',
                'example' => 10,
            ],
            'rows.*.payment_method' => [
                'description' => 'Optional payment method.',
                'example' => 'bank',
            ],
            'rows.*.basic_salary' => [
                'description' => 'Optional basic salary.',
                'example' => 1500,
            ],
            'rows.*.deduction' => [
                'description' => 'Optional deduction amount.',
                'example' => 200,
            ],
            'rows.*.allowance' => [
                'description' => 'Optional allowance amount.',
                'example' => 100,
            ],
            'rows.*.net' => [
                'description' => 'Optional net amount.',
                'example' => 1400,
            ],
            'rows.*.paid_at' => [
                'description' => 'Optional paid datetime.',
                'example' => '2026-02-28 10:00:00',
            ],
            'rows.*.status' => [
                'description' => 'Optional status.',
                'example' => 'paid',
            ],
        ];
    }
}
