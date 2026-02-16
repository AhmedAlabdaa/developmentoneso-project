<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceServiceLineResource extends JsonResource
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
            'ledger_account_id' => $this->ledger_account_id,
            'ledger_name' => $this->ledger ? $this->ledger->name : null,
            'invoice_service_id' => $this->invoice_service_id,
            'amount_debit' => $this->amount_debit,
            'amount_credit' => $this->amount_credit,
            'vatable' => $this->vatable,
            'note' => $this->note,
            'source_amount' => $this->source_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
