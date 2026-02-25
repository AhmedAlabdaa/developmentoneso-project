<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeVisaStage extends Model
{
    use HasFactory;

    protected $table = 'employee_visa_stages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'employee_id',
        'step_id',
        'hr_issue_date',
        'hr_file_number',
        'hr_expiry_date',
        'hr_attach_file',
        'ica_proof',
        'fin_paid_amount',
        'fin_zoho_proof',
        'fin_gov_invoice_proof'
    ];

    protected $casts = [
        'hr_issue_date' => 'date',
        'hr_expiry_date' => 'date',
        'fin_paid_amount' => 'decimal:2'
    ];
}
