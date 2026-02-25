<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enum\GeneralStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Amp3ActionNotify extends Model
{
    
    protected $fillable = [
        'status',
        'note',
        'am_contract_movement_id',
        'amount',
        'refund_date',
        'created_by',
        'updated_by',
    ];  


    protected $casts = [
        'status' => GeneralStatus::class,
        'amount' => 'decimal:2',
        'refund_date' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function movementContract(): BelongsTo
    {
        return $this->belongsTo(AmContractMovment::class, 'am_contract_movement_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', GeneralStatus::PENDING);
    }
}
