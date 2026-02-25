<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Office extends Model
{
    protected $table = 'office';

    public $timestamps = true;

    protected $fillable = [
        'candidate_id',
        'type',
        'category',
        'returned_date',
        'expiry_date',
        'ica_proof',
        'overstay_days',
        'fine_amount',
        'passport_status',
        'created_by',
        'status',
        'update_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'returned_date' => 'date',
        'expiry_date'   => 'date',
        'overstay_days' => 'integer',
        'fine_amount'   => 'decimal:2',
        'status'        => 'integer',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'candidate_id', 'id');
    }
}
