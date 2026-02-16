<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalHeaderResource extends JsonResource
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
            'posting_date' => $this->posting_date?->format('Y-m-d'),
            'status' => $this->status?->value ?? $this->status,
            'status_label' => $this->status?->name ?? null,
            
            // Morphs
            'source_type' => $this->source_type,
            'source_id' => $this->source_id,
            'pre_src_type' => $this->pre_src_type,
            'pre_src_id' => $this->pre_src_id,
            
            // Content
            'note' => $this->note,
            'meta_json' => $this->meta_json,
            
            // Totals
            'total_debit' => $this->total_debit,
            'total_credit' => $this->total_credit,
            
            // User tracking
            'created_by' => $this->created_by,
            'posted_by' => $this->posted_by,
            'posted_at' => $this->posted_at?->toISOString(),
            
            // Nested lines
            'lines' => JournalTranLineResource::collection($this->whenLoaded('lines')),
            
            // Polymorphic relationships
            'source' => $this->whenLoaded('source'),
            'pre_src' => $this->whenLoaded('preSrc'),
            
            // Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
