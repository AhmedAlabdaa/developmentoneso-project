<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    protected $fillable = [
        'receipt_number',
        'receipt_date',
        'payer_type',
        'customer_id',
        'walkin_name',
        'amount',
        'payment_method',
        'reference_no',
        'attachment_path',
        'status',
        'notes',
        'cancel_reason',
        'created_by',
        'approved_by',
        'approved_at',
        'cancelled_by',
        'cancelled_at',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'approved_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    protected $appends = ['payer_display'];

    public function customer()
    {
        return $this->belongsTo(\App\Models\CRM::class, 'customer_id');
    }

    public function getPayerDisplayAttribute(): string
    {
        if ($this->payer_type === 'customer' && $this->customer) {
            $fn = $this->customer->first_name ?? '';
            $ln = $this->customer->last_name ?? '';
            $name = trim($fn . ' ' . $ln);
            if ($name === '') $name = 'Customer';
            return $name . ' (ID: ' . $this->customer_id . ')';
        }
        return (string) ($this->walkin_name ?? '');
    }
}
