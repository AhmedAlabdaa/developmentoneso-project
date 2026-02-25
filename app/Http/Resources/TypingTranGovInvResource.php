<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\JournalHeaderResource;
use App\Http\Resources\LedgerOfAccountResource;

class TypingTranGovInvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
  
        $amountReceived = (float) $this->amount_received;
        $amountOfInvoice = (float) $this->amount_of_invoice;
        
        if ($amountReceived == 0) {
            $paymentStatus = 'pending';
        } elseif ($amountReceived >= $amountOfInvoice) {
            $paymentStatus = 'paid';
        } else {
            $paymentStatus = 'partial';
        }

        return [
            'id' => $this->id,
            'serial_no' => $this->serial_no,
            'gov_dw_no' => $this->gov_dw_no,
            'gov_inv_attachments' => $this->gov_inv_attachments,
            'maid_id' => $this->maid_id,
            'ledger_id' => $this->ledger_id,
            'ledger' => new LedgerOfAccountResource($this->whenLoaded('ledger')),
            'customer_mobile' => $this->whenLoaded('ledger', function () {
                return $this->ledger?->crm?->mobile;
            }),
            'amount_received' => $this->amount_received,
            'amount_of_invoice' => $this->amount_of_invoice,
            'services_json' => $this->services_json,
            'payment_status' => $paymentStatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'journal' => new JournalHeaderResource($this->whenLoaded('journal')),
            'receipt_vouchers' => ReceiptVoucherResource::collection($this->whenLoaded('receiptVoucher')),
        ];
    }
}
