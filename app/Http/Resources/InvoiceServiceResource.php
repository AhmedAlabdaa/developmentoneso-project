<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Calculate total amount and breakdown from lines
        // Mimic logic from TypingTranGovInvService to ensure consistency
        $totalAmount = 0;
        $govtFee = 0;
        $centerFee = 0;
        $serviceCharge = 0;
        $tax = 0;
        $isTaxable = false;

        if ($this->relationLoaded('lines')) {
            foreach ($this->lines as $line) {
                // Determine Line Amount (Net of Credit - Debit)
                // Service lines usually have Credit (Revenue) or Debit (Expense/Contra)
                $credit = (float) ($line->amount_credit ?? 0);
                $debit = (float) ($line->amount_debit ?? 0);
                $lineNetTotal = $credit - $debit;

                $totalAmount += $lineNetTotal;

                // Check if this line is explicitly a VAT line
                $isExplicitVat = false;
                if ($line->ledger && strtoupper($line->ledger->name) === 'VAT OUTPUT') {
                    $isExplicitVat = true;
                    $tax += $lineNetTotal;
                // Don't add to other fees if it's explicitly VAT
                    continue; 
                }

                // Initialize Fee and Tax defaults
                $lineFee = $lineNetTotal;
                $lineTax = 0;

                if ($line->vatable) {
                    $isTaxable = true;
                    // Inclusive VAT: Amount = Net + Tax
                    // Net = Amount / 1.05
                    // Tax = Amount - Net
                    $lineFee = round($lineNetTotal / 1.05, 2);
                    $lineTax = round($lineNetTotal - $lineFee, 2);
                }
                
                $tax += $lineTax;

                if ($line->ledger) {
                    $class = $line->ledger->class;
                    
                    // Income (Revenue) -> Center Fee
                    if ($class === \App\Enum\LedgerClass::INCOME) {
                        $centerFee += $lineFee;
                    } 
                    // Liability, Expense, Asset, Equity -> Govt Fee
                    // User Rule: "credit and assets" (Netting assets impacts Govt Fee costs)
                    elseif ($class === \App\Enum\LedgerClass::LIABILITY || 
                            $class === \App\Enum\LedgerClass::EXPENSE ||
                            $class === \App\Enum\LedgerClass::ASSET || 
                            $class === \App\Enum\LedgerClass::EQUITY) {
                        $govtFee += $lineFee;
                    } else {
                         // Default fallback
                        $govtFee += $lineFee;
                    }
                } else {
                     $govtFee += $lineFee;
                }
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'note' => $this->note,
            'status' => $this->status,
            'type' => $this->type,
            'settings' => $this->settings,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_by_name' => $this->creator ? $this->creator->name : null,
            'updated_by_name' => $this->updater ? $this->updater->name : null,
            'total_amount' => $totalAmount,
            
            // Exposed breakdown fields
            'govt_fee' => $govtFee,
            'center_fee' => $centerFee,
            'service_charge' => $serviceCharge,
            'tax' => $tax,
            'is_taxable' => $isTaxable,

            'lines' => InvoiceServiceLineResource::collection($this->whenLoaded('lines')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
