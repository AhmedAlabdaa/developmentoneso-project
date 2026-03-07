<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AmMaidPayRollResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'year' => $this->year,
            'month' => $this->month,
            'payment_method' => $this->payment_method,
            'basic_salary' => $this->basic_salary,
            'deduction' => $this->deduction,
            'allowance' => $this->allowance,
            'net' => $this->net,
            'note' => $this->note,
            'paid_at' => $this->paid_at,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'employee' => $this->whenLoaded('employee'),
            'created_by_user' => $this->whenLoaded('createdBy'),
            'updated_by_user' => $this->whenLoaded('updatedBy'),
        ];
    }
}
