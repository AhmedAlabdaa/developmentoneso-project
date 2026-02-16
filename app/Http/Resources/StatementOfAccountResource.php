<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatementOfAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ledger' => [
                'id' => $this->resource['ledger']->id,
                'name' => $this->resource['ledger']->name,
            ],
            'date_from' => $this->resource['date_from'],
            'date_to' => $this->resource['date_to'],
            'opening_balance' => $this->resource['opening_balance'],
            'transactions' => $this->resource['transactions'],
            'summary' => $this->resource['summary'],
        ];
    }
}
