<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\PaymentMode;

class ReceiptVoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get payment mode label
        $paymentModeLabel = null;
        if ($this->payment_mode) {
            $paymentModeEnum = PaymentMode::tryFrom($this->payment_mode);
            $paymentModeLabel = $paymentModeEnum?->label();
        }

        // Calculate amount from journal lines (sum of debits or credits)
        $amount = 0;
        if ($this->relationLoaded('journal') && $this->journal) {
            $amount = $this->journal->total_debit ?? 0;
        }

        return [
            'id' => $this->id,
            'serial_number' => $this->serial_number,
            'source_type' => $this->source_type,
            'source_id' => $this->source_id,
            'attachments' => $this->attachments,
            'status' => $this->status,
            'payment_mode' => $this->payment_mode,
            'payment_mode_label' => $paymentModeLabel,
            'amount' => $amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'source' => $this->whenLoaded('source'),
            'journal' => new JournalHeaderResource($this->whenLoaded('journal')),
        ];
    }
}
