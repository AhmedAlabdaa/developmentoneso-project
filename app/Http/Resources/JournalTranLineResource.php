<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalTranLineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'journal_header_id' => $this->journal_header_id,
            'employee_id' => $this->employee_id,
            'candidate_id' => $this->employee_id,
            'ledger_id' => $this->ledger_id,
            'debit' => $this->debit,
            'credit' => $this->credit,
            'note' => $this->note,
            'created_by' => $this->created_by,
            
            // Related data
            'ledger' => $this->whenLoaded('ledger', function () {
                return [
                    'id' => $this->ledger->id,
                    'name' => $this->ledger->name,
                    'class' => $this->ledger->class,
                    'sub_class' => $this->ledger->sub_class,
                    'group' => $this->ledger->group,
                    'type' => $this->ledger->type,
                ];
            }),
            
            'employee' => $this->whenLoaded('employee', function () {
                return [
                    'id' => $this->employee->id,
                    'name' => $this->employee->name ?? null,
                    // Add other employee fields as needed
                ];
            }),

            'header' => $this->whenLoaded('header', function () {
                return [
                    'id' => $this->header->id,
                    'posting_date' => $this->header->posting_date?->format('Y-m-d'),
                    'status' => $this->header->status?->value ?? $this->header->status,
                    'status_label' => $this->header->status?->name ?? null,
                    'source_type' => class_basename($this->header->source_type),
                    'source_id' => $this->header->source_id,
                    'source_name' => $this->header->source?->name ?? $this->header->source?->title ?? class_basename($this->header->source_type),
                    'note' => $this->header->note,
                    'total_debit' => $this->header->total_debit,
                    'total_credit' => $this->header->total_credit,
                ];
            }),

            // Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
