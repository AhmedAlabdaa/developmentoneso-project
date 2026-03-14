<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAmMonthlyContractEmployeeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'passport_expiry_date' => 'required|date',
            'passport_no' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('employees', 'passport_no'),
            ],
            'emirates_id' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('employees', 'emirates_id'),
            ],
            'salary' => 'nullable|numeric|min:0',
            'payment_type' => 'nullable|string|max:50',
            'inside_country_or_outside' => ['nullable', 'integer', Rule::in([1, 2])],
        ];
    }
}
