<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'candidate_id',
        'client_id',
        'type',
        'candidate_name',
        'sponsor_name',
        'passport_no',
        'nationality',
        'foreign_partner',
        'agreement_no',
        'contract_start_date',
        'contract_end_date',
        'return_date',
        'maid_worked_days',
        'contracted_amount',
        'salary',
        'worker_salary_for_work_days',
        'salary_payment_method',
        'payment_proof',
        'office_charges',
        'refunded_amount',
        'refund_date',
        'original_passport',
        'worker_belongings',
        'status',
        'sales_name',
        'updated_by_sales_name',
        'refund_type',
        'package',
    ];

    protected $casts = [
        'candidate_id' => 'integer',
        'client_id' => 'integer',
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'return_date' => 'date',
        'refund_date' => 'date',
        'maid_worked_days' => 'integer',
        'contracted_amount' => 'decimal:2',
        'salary' => 'decimal:2',
        'worker_salary_for_work_days' => 'decimal:2',
        'office_charges' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'original_passport' => 'boolean',
        'worker_belongings' => 'boolean',
    ];
}
