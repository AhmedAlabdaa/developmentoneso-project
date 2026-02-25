<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeductionPayrollResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'deduction_date' => $this->deduction_date,
            'employee_id' => $this->employee_id,
            'payroll_year' => $this->payroll_year,
            'payroll_month' => $this->payroll_month,
            'amount_deduction' => $this->amount_deduction,
            'amount_allowance' => $this->amount_allowance,
            'note' => $this->note,
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

