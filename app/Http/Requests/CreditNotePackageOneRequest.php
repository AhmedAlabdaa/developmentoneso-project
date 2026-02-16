<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditNotePackageOneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => 'required|integer|exists:invoices,invoice_id',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function bodyParameters(): array
    {
        return [
            'invoice_id' => [
                'description' => 'The ID of the Invoice to create a credit note for. This will reverse the journal entries.',
                'example' => 1,
            ],
        ];
    }
}
