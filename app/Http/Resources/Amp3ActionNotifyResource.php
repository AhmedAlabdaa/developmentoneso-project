<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Amp3ActionNotifyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'am_contract_movement_id' => $this->am_contract_movement_id,
            'amount' => $this->amount,
            'note' => $this->note,
            'refund_date' => $this->refund_date,
            'status' => $this->status,
            'status_label' => $this->status?->label(),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'movement_contract' => $this->whenLoaded('movementContract'),
        ];
    }
}
