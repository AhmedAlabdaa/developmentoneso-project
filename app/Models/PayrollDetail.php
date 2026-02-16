<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'CN_Number',
        'agreement_reference_no',
        'salary_amount',
        'payable_amount',
        'number_of_days',
        'agreement_start_date',
        'agreement_end_date',
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_reference_no', 'reference_no');
    }
}
