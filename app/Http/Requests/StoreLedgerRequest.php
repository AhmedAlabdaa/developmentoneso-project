<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLedgerRequest extends FormRequest
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
            'updated_by' => \Auth::id() ?? 1,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the ledger ID from the route - apiResource uses 'ledger' as parameter name
        $ledgerId = $this->route('ledger');

        return [
            'name' => 'required|string|max:255|unique:ledger_of_accounts,name,' . ($ledgerId ?? 'NULL'),
            'class' => 'required|integer',
            'sub_class' => 'required|integer',
            'group' => 'nullable|string|max:255',
            'spacial' => 'required|integer',
            'type' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
            'created_by' => 'required|integer|exists:users,id',
            'updated_by' => 'required|integer|exists:users,id',
        ];
    }
}
