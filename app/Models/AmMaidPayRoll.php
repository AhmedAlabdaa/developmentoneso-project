<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmMaidPayRoll extends Model
{
    /** @use HasFactory<\Database\Factories\AmMaidPayRollFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'payment_method',
        'basic_salary',
        'deduction',
        'allowance',
        'net',
        'note',
        'paid_at',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'basic_salary' => 'decimal:2',
        'deduction' => 'decimal:2',
        'allowance' => 'decimal:2',
        'net' => 'decimal:2',
        'paid_at' => 'datetime',
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
