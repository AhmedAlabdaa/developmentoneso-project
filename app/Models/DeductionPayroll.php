<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeductionPayroll extends Model
{
    protected $fillable = [
        'deduction_date',
        'employee_id',
        'payroll_year',
        'payroll_month',
        'amount_deduction',
        'amount_allowance',
        'note',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'deduction_date' => 'date',
        'amount_deduction' => 'decimal:2',
        'amount_allowance' => 'decimal:2',
        'payroll_year' => 'integer',
        'payroll_month' => 'integer',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
