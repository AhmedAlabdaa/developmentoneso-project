<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'pay_period_start',
        'pay_period_end',
        'number_of_candidates',
        'total_amount',
        'status',
        'type',
        'remarks',
        'created_by',
    ];

    public function details()
    {
        return $this->hasMany(PayrollDetail::class);
    }

    public function agreements()
    {
        return $this->hasManyThrough(
            Agreement::class,
            PayrollDetail::class,
            'payroll_id',            // Foreign key on PayrollDetail
            'reference_no',          // Foreign key on Agreement
            'id',                    // Local key on Payroll
            'agreement_reference_no' // Local key on PayrollDetail
        );
    }
}
