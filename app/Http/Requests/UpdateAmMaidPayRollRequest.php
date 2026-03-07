<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAmMaidPayRollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'sometimes|integer|exists:employees,id',
            'year' => 'sometimes|integer|min:2020|max:2099',
            'month' => 'sometimes|integer|min:1|max:12',
            'payment_method' => 'nullable|string|max:20',
            'basic_salary' => 'sometimes|numeric|min:0',
            'deduction' => 'sometimes|numeric|min:0',
            'allowance' => 'sometimes|numeric|min:0',
            'net' => 'sometimes|numeric|min:0',
            'note' => 'nullable|string',
            'paid_at' => 'nullable|date',
            'status' => 'nullable|string|max:20',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'employee_id' => [
                'description' => 'Employee ID.',
                'example' => 10,
            ],
            'year' => [
                'description' => 'Payroll year.',
                'example' => 2026,
            ],
            'month' => [
                'description' => 'Payroll month (1-12).',
                'example' => 2,
            ],
            'payment_method' => [
                'description' => 'Payment method.',
                'example' => 'bank',
            ],
            'basic_salary' => [
                'description' => 'Basic salary.',
                'example' => 1500,
            ],
            'deduction' => [
                'description' => 'Deduction amount.',
                'example' => 200,
            ],
            'allowance' => [
                'description' => 'Allowance amount.',
                'example' => 100,
            ],
            'net' => [
                'description' => 'Net amount.',
                'example' => 1400,
            ],
            'note' => [
                'description' => 'Optional note.',
                'example' => 'Updated payroll note',
            ],
            'paid_at' => [
                'description' => 'Optional paid datetime.',
                'example' => '2026-02-28 10:00:00',
            ],
            'status' => [
                'description' => 'Status.',
                'example' => 'paid',
            ],
        ];
    }
}
