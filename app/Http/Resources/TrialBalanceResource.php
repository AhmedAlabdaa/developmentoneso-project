<?php

namespace App\Http\Resources;

use App\Enum\LedgerClass;
use App\Enum\SubClass;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrialBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $closingBalance = (float) $this->closing_balance;
        
        return [
            'ledger_id' => $this->ledger_id,
            'ledger_name' => $this->ledger_name,
            'class' => $this->class ? LedgerClass::tryFrom($this->class)?->label() : null,
            'class_id' => $this->class,
            'sub_class' => $this->sub_class ? SubClass::tryFrom($this->sub_class)?->label() : null,
            'sub_class_id' => $this->sub_class,
            'group' => $this->group,
            'total_debit' => number_format((float) $this->total_debit, 2, '.', ''),
            'total_credit' => number_format((float) $this->total_credit, 2, '.', ''),
            'closing_balance' => number_format(abs($closingBalance), 2, '.', ''),
            'balance_type' => $closingBalance >= 0 ? 'DR' : 'CR',
        ];
    }
}
