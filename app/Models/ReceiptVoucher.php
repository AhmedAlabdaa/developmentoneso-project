<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReceiptVoucher extends Model
{
    use HasFactory;

    protected $table = 'receipt_voucher';

    protected $fillable = [
        'serial_number',
        'attachments',
        'status',
        'payment_mode',
    ];

    protected $casts = [
        'attachments' => 'array',
        'payment_mode' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $lastId = self::max('id');
            $nextId = $lastId ? $lastId + 1 : 1;
            $model->serial_number = 'RV-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        });
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }

    public function journal()
    {
        return $this->morphOne(JournalHeader::class, 'source');
    }
}
