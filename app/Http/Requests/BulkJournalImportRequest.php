<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkJournalImportRequest extends FormRequest
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
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'file.required' => 'A CSV file is required.',
            'file.file' => 'The uploaded item must be a file.',
            'file.mimes' => 'The file must be a CSV file.',
            'file.max' => 'The file must not exceed 5MB.',
        ];
    }
}
